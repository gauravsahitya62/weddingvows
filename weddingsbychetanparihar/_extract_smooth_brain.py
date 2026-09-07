"""Restore smooth multi-lobe Q-path from transcript (~44Q) for services cutout."""
from __future__ import annotations

import re
from pathlib import Path

from PIL import Image, ImageDraw

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FP = THEME / "front-page.php"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
TRANS = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"
    r"\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911"
    r"\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)


def parse_path(d: str) -> list[tuple[float, float]]:
    tokens = re.findall(r"[MmLlHhVvCcSsQqTtAaZz]|-?\d*\.?\d+(?:e[-+]?\d+)?", d)
    pts: list[tuple[float, float]] = []
    i = 0
    cmd = None
    cx = cy = 0.0
    while i < len(tokens):
        t = tokens[i]
        if re.match(r"[A-Za-z]", t):
            cmd = t
            i += 1
            continue
        if cmd is None:
            i += 1
            continue
        if cmd in "MmLl":
            x, y = float(tokens[i]), float(tokens[i + 1])
            i += 2
            if cmd == "m" and pts:
                x += cx
                y += cy
            elif cmd == "l":
                x += cx
                y += cy
            cx, cy = x, y
            pts.append((cx, cy))
            cmd = "L" if cmd == "M" else ("l" if cmd == "m" else cmd)
        elif cmd in "Hh":
            x = float(tokens[i])
            i += 1
            if cmd == "h":
                x += cx
            cx = x
            pts.append((cx, cy))
        elif cmd in "Vv":
            y = float(tokens[i])
            i += 1
            if cmd == "v":
                y += cy
            cy = y
            pts.append((cx, cy))
        elif cmd in "Qq":
            x1, y1 = float(tokens[i]), float(tokens[i + 1])
            x, y = float(tokens[i + 2]), float(tokens[i + 3])
            i += 4
            if cmd == "q":
                x1 += cx
                y1 += cy
                x += cx
                y += cy
            for tt in (0.25, 0.5, 0.75, 1.0):
                ox = (1 - tt) ** 2 * cx + 2 * (1 - tt) * tt * x1 + tt**2 * x
                oy = (1 - tt) ** 2 * cy + 2 * (1 - tt) * tt * y1 + tt**2 * y
                pts.append((ox, oy))
            cx, cy = x, y
        elif cmd in "Cc":
            x1, y1 = float(tokens[i]), float(tokens[i + 1])
            x2, y2 = float(tokens[i + 2]), float(tokens[i + 3])
            x, y = float(tokens[i + 4]), float(tokens[i + 5])
            i += 6
            if cmd == "c":
                x1 += cx
                y1 += cy
                x2 += cx
                y2 += cy
                x += cx
                y += cy
            for tt in (0.25, 0.5, 0.75, 1.0):
                mt = 1 - tt
                ox = mt**3 * cx + 3 * mt**2 * tt * x1 + 3 * mt * tt**2 * x2 + tt**3 * x
                oy = mt**3 * cy + 3 * mt**2 * tt * y1 + 3 * mt * tt**2 * y2 + tt**3 * y
                pts.append((ox, oy))
            cx, cy = x, y
        else:
            i += 1
    return pts


def inset(pts: list[tuple[float, float]], amount: float) -> list[tuple[float, float]]:
    n = len(pts)
    out = []
    for i, (x, y) in enumerate(pts):
        x0, y0 = pts[(i - 1) % n]
        x1, y1 = pts[(i + 1) % n]
        dx, dy = x1 - x0, y1 - y0
        L = (dx * dx + dy * dy) ** 0.5 or 1.0
        nx, ny = -dy / L, dx / L
        out.append((x + nx * amount, y + ny * amount))
    return out


def poly(pts: list[tuple[float, float]]) -> str:
    return "M " + " ".join(f"{x:.2f} {y:.2f}" for x, y in pts) + " Z"


def norm(pts: list[tuple[float, float]]) -> str:
    return "M " + " ".join(f"{x/360:.5f} {y/460:.5f}" for x, y in pts) + " Z"


def main() -> None:
    best = None
    best_q = 0
    for i, line in enumerate(TRANS.read_text(encoding="utf-8", errors="ignore").splitlines()):
        for m in re.finditer(r'd="(M[^"]{80,})"', line):
            d = m.group(1)
            q = d.count("Q") + d.count("q")
            # Prefer rich multi-lobe Q paths; skip top-only scallops (~22Q)
            if 30 <= q <= 60 and q > best_q:
                best = d
                best_q = q
                print(f"candidate line {i} Q={q} len={len(d)}")

    if not best:
        raise SystemExit("no smooth Q path found")

    outer_q = best
    pts = parse_path(outer_q)
    print(f"parsed samples={len(pts)} from Q={best_q}")
    # Use original Q path for outer (smooth); polyline only for inset approx
    outer = outer_q if outer_q.endswith("Z") or outer_q.endswith("z") else outer_q + " Z"
    # If path uses relative coords / doesn't look like 360x460, keep as-is from transcript
    xs = [p[0] for p in pts]
    ys = [p[1] for p in pts]
    print(f"bbox {min(xs):.1f},{min(ys):.1f} -> {max(xs):.1f},{max(ys):.1f}")

    # Prefer original Q string for outer if bbox roughly matches art frame
    if min(xs) > -20 and max(xs) < 380 and min(ys) > -20 and max(ys) < 480:
        outer_path = outer
        inner_pts = inset(pts, 7.0)
        # Rebuild inner as smooth-ish polyline (fine for thin stroke)
        inner_path = poly(inner_pts)
        clip_path = norm(pts)
        mask_d = poly(pts)
    else:
        raise SystemExit(f"unexpected bbox, refusing to apply")

    php = FP.read_text(encoding="utf-8")
    php2, n1 = re.subn(
        r"(\$outer = ')M[^']+(';)",
        rf"\1{outer_path}\2",
        php,
        count=1,
    )
    php2, n2 = re.subn(
        r"(\$inner = ')M[^']+(';)",
        rf"\1{inner_path}\2",
        php2,
        count=1,
    )
    php2, n3 = re.subn(
        r'(<path d=")M[^"]+(" />\s*</clipPath>)',
        rf"\1{clip_path}\2",
        php2,
        count=1,
    )
    if n1 != 1 or n2 != 1 or n3 != 1:
        raise SystemExit(f"replace failed n1={n1} n2={n2} n3={n3}")
    FP.write_text(php2, encoding="utf-8")
    MASK.write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 460" preserveAspectRatio="none">\n'
        f'  <path fill="#fff" d="{mask_d}"/>\n'
        "</svg>\n",
        encoding="utf-8",
    )

    # Preview
    img = Image.new("RGBA", (360, 460), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)
    draw.polygon([(x, y) for x, y in pts], fill=(238, 228, 208, 255))
    for i in range(len(pts)):
        a = pts[i]
        b = pts[(i + 1) % len(pts)]
        draw.line([a, b], fill=(158, 118, 80, 255), width=3)
    for i in range(len(inner_pts)):
        a = inner_pts[i]
        b = inner_pts[(i + 1) % len(inner_pts)]
        draw.line([a, b], fill=(158, 118, 80, 220), width=1)
    out = ROOT / "_brain_smooth_preview.png"
    img.save(out)
    print("wrote", out)
    print("updated front-page.php + brain-mask.svg")


if __name__ == "__main__":
    main()
