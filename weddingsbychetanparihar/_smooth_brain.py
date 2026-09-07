"""Convert current L-polyline brain into smooth Q-curves and sync theme files."""
from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FP = THEME / "front-page.php"
CSS = THEME / "assets" / "css" / "site.css"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
FN = THEME / "functions.php"

VB_W, VB_H = 360.0, 460.0
CX, CY = VB_W / 2.0, VB_H / 2.0
INNER_SCALE = 0.965


def parse_points(d: str) -> list[tuple[float, float]]:
    nums = [float(x) for x in re.findall(r"-?\d+(?:\.\d+)?", d)]
    return [(nums[i], nums[i + 1]) for i in range(0, len(nums) - 1, 2)]


def fmt(n: float) -> str:
    s = f"{n:.1f}"
    if s.endswith(".0"):
        return s[:-2]
    return s


def points_to_q(pts: list[tuple[float, float]]) -> str:
    """Convert polyline vertices to smooth quadratic path.

    Midpoints of each edge become on-curve points; original vertices
    become Q control points. That rounds corners instead of drawing
    straight mid-point Beziers.
    """
    if len(pts) < 4:
        raise ValueError("need enough points")

    # Ensure closed loop without duplicate last==first
    if abs(pts[0][0] - pts[-1][0]) < 0.01 and abs(pts[0][1] - pts[-1][1]) < 0.01:
        pts = pts[:-1]

    n = len(pts)
    mids = [
        ((pts[i][0] + pts[(i + 1) % n][0]) / 2.0, (pts[i][1] + pts[(i + 1) % n][1]) / 2.0)
        for i in range(n)
    ]

    # M mid[-1]  then for i in 0..n-1: Q verts[i] mids[i]
    start = mids[-1]
    parts = [f"M {fmt(start[0])},{fmt(start[1])}"]
    for i in range(n):
        ctrl = pts[i]
        end = mids[i]
        parts.append(f"Q {fmt(ctrl[0])},{fmt(ctrl[1])} {fmt(end[0])},{fmt(end[1])}")
    parts.append("Z")
    return " ".join(parts)


def shrink(pts: list[tuple[float, float]], scale: float) -> list[tuple[float, float]]:
    return [((x - CX) * scale + CX, (y - CY) * scale + CY) for x, y in pts]


def normalize(d: str) -> str:
    """Absolute pixel path -> objectBoundingBox 0..1 for viewBox 360x460."""
    tokens = re.split(r"\s+", d.strip())
    out: list[str] = []
    i = 0
    while i < len(tokens):
        t = tokens[i]
        if t in {"M", "L", "Q", "Z", "z"}:
            out.append(t.upper() if t != "z" else "Z")
            i += 1
            continue
        if "," in t:
            xs, ys = t.split(",", 1)
            x = float(xs) / VB_W
            y = float(ys) / VB_H
            out.append(f"{x:.4f},{y:.4f}")
            i += 1
            continue
        # two separate numbers
        x = float(t) / VB_W
        y = float(tokens[i + 1]) / VB_H
        out.append(f"{x:.4f},{y:.4f}")
        i += 2
    return " ".join(out)


def main() -> None:
    text = FP.read_text(encoding="utf-8")
    m = re.search(r"\$outer = '([^']+)'", text)
    if not m:
        raise SystemExit("outer not found")
    outer_old = m.group(1)
    pts = parse_points(outer_old)
    print(f"parsed {len(pts)} points from current L-path")

    outer = points_to_q(pts)
    inner_pts = shrink(pts if abs(pts[0][0] - pts[-1][0]) > 0.01 else pts[:-1], INNER_SCALE)
    # rebuild inner from same densify logic on shrunk verts
    if abs(pts[0][0] - pts[-1][0]) < 0.01 and abs(pts[0][1] - pts[-1][1]) < 0.01:
        base = pts[:-1]
    else:
        base = pts
    inner = points_to_q(shrink(base, INNER_SCALE))
    clip = normalize(outer)

    qn = len(re.findall(r"\bQ\b", outer))
    print(f"smooth outer Q-count={qn} len={len(outer)}")
    print(outer[:180], "...")

    # Update front-page.php
    text2, n1 = re.subn(r"\$outer = '[^']+';", f"$outer = '{outer}';", text, count=1)
    text2, n2 = re.subn(r"\$inner = '[^']+';", f"$inner = '{inner}';", text2, count=1)
    # clipPath path d=
    text2, n3 = re.subn(
        r'(<clipPath id="wbc-art-clip"[^>]*>\s*<path d=")[^"]+(")',
        r"\1" + clip + r"\2",
        text2,
        count=1,
        flags=re.S,
    )
    if n1 != 1 or n2 != 1 or n3 != 1:
        raise SystemExit(f"replace counts outer={n1} inner={n2} clip={n3}")
    FP.write_text(text2, encoding="utf-8")
    print("updated front-page.php")

    # brain-mask.svg
    mask = f'''<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 460" preserveAspectRatio="none">
  <path fill="#fff" d="{outer}"/>
</svg>
'''
    MASK.write_text(mask, encoding="utf-8")
    print("updated brain-mask.svg")

    # bump version
    fn = FN.read_text(encoding="utf-8")
    fn2, n4 = re.subn(
        r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'[^']+'\s*\)",
        "define( 'WBC_THEME_VERSION', '3.0.2' )",
        fn,
        count=1,
    )
    if n4 != 1:
        # try existing
        fn2, n4 = re.subn(
            r"WBC_THEME_VERSION'\s*,\s*'[^']+'",
            "WBC_THEME_VERSION', '3.0.2'",
            fn,
            count=1,
        )
    FN.write_text(fn2, encoding="utf-8")
    print(f"bumped version n={n4}")

    # ensure cream bg still in css (spot check)
    css = CSS.read_text(encoding="utf-8")
    if "#eee4d0" not in css:
        print("WARNING: #eee4d0 missing from site.css")
    else:
        print("cream #eee4d0 present")


if __name__ == "__main__":
    main()
