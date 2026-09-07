"""Rebuild stroke/mask paths from the existing correct objectBoundingBox clipPath."""
from __future__ import annotations

import re
from pathlib import Path

import numpy as np
from PIL import Image, ImageDraw

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FRONT = THEME / "front-page.php"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
CSS = THEME / "assets" / "css" / "site.css"
FUNCS = THEME / "functions.php"
REF = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"
    r"\assets\c__Users_Asus_AppData_Roaming_Cursor_User_workspaceStorage_"
    r"793ad060b5b1740f1392a74d85beebef_images_image-75cf0807-e90b-430c-a226-1cbab9c741f2.png"
)

VB_W, VB_H = 360.0, 460.0


def parse_clip_points(front_text: str) -> list[tuple[float, float]]:
    m = re.search(
        r'clipPath id="wbc-art-clip"[^>]*>\s*<path d="([^"]+)"',
        front_text,
        re.S,
    )
    if not m:
        raise SystemExit("clipPath not found")
    d = m.group(1)
    nums = [float(x) for x in re.findall(r"[-+]?\d*\.?\d+(?:[eE][-+]?\d+)?", d)]
    pts = [(nums[i], nums[i + 1]) for i in range(0, len(nums) - 1, 2)]
    return pts


def to_user(pts: list[tuple[float, float]]) -> np.ndarray:
    arr = np.array(pts, dtype=np.float64)
    arr[:, 0] *= VB_W
    arr[:, 1] *= VB_H
    return arr


def path_d(pts: np.ndarray) -> str:
    parts = [f"M{pts[0,0]:.2f} {pts[0,1]:.2f}"]
    for i in range(1, len(pts)):
        parts.append(f"L{pts[i,0]:.2f} {pts[i,1]:.2f}")
    parts.append("Z")
    return " ".join(parts)


def smooth(pts: np.ndarray, passes: int = 2) -> np.ndarray:
    out = pts.copy()
    n = len(out)
    for _ in range(passes):
        nxt = out.copy()
        for i in range(n):
            nxt[i] = 0.25 * out[(i - 1) % n] + 0.5 * out[i] + 0.25 * out[(i + 1) % n]
        out = nxt
    return out


def inset(pts: np.ndarray, amount: float) -> np.ndarray:
    c = pts.mean(axis=0)
    v = pts - c
    norms = np.linalg.norm(v, axis=1, keepdims=True)
    norms = np.maximum(norms, 1e-6)
    scale = 1.0 - amount / norms
    return c + v * scale


def sample_ref_colors(path: Path) -> dict[str, str]:
    im = Image.open(path).convert("RGB")
    w, h = im.size
    # Background cream — force exact #eee4d0
    # Sample heading bronze from left text area
    samples = []
    for y in range(int(h * 0.12), int(h * 0.28), max(1, h // 80)):
        for x in range(int(w * 0.08), int(w * 0.35), max(1, w // 60)):
            r, g, b = im.getpixel((x, y))
            # dark-ish bronze (not cream)
            if r + g + b < 420 and r > 40 and abs(r - g) < 80:
                samples.append((r, g, b))
    if not samples:
        text = (90, 72, 52)
    else:
        arr = np.array(samples, dtype=np.float64)
        text = tuple(int(round(x)) for x in arr.mean(axis=0))

    # Gold border from right silhouette edge
    border_samples = []
    for y in range(int(h * 0.15), int(h * 0.85), max(1, h // 50)):
        for x in range(int(w * 0.55), int(w * 0.95), max(1, w // 40)):
            r, g, b = im.getpixel((x, y))
            # muted metallic gold/bronze band
            if 90 < r < 200 and 70 < g < 170 and 40 < b < 140 and r > g >= b:
                border_samples.append((r, g, b))
    if not border_samples:
        stroke = (138, 109, 61)
    else:
        arr = np.array(border_samples, dtype=np.float64)
        stroke = tuple(int(round(x)) for x in arr.mean(axis=0))

    def hexrgb(t):
        return f"#{t[0]:02x}{t[1]:02x}{t[2]:02x}"

    return {
        "bg": "#eee4d0",
        "text": hexrgb(text),
        "stroke": hexrgb(stroke),
        "muted": "#6a5a48",
    }


def main() -> None:
    front = FRONT.read_text(encoding="utf-8")
    pts01 = parse_clip_points(front)
    pts = to_user(pts01)
    pts = smooth(pts, passes=1)

    # Ensure closed and centered-ish in viewBox
    outer_pts = pts.copy()
    # Slight padding from edges if needed
    mn = outer_pts.min(axis=0)
    mx = outer_pts.max(axis=0)
    print("bbox", mn, mx, "n=", len(outer_pts))

    inner_pts = inset(outer_pts, 6.0)
    outer_d = path_d(outer_pts)
    inner_d = path_d(inner_pts)

    # Update $outer / $inner PHP vars
    front2, n_outer = re.subn(
        r"\$outer = '[^']*';",
        f"$outer = '{outer_d}';",
        front,
        count=1,
    )
    front2, n_inner = re.subn(
        r"\$inner = '[^']*';",
        f"$inner = '{inner_d}';",
        front2,
        count=1,
    )

    # Also switch clipPath to userSpace and same outer path for perfect sync
    # Keep objectBoundingBox: rebuild from outer_pts normalized
    clip_pts = outer_pts.copy()
    clip_pts[:, 0] /= VB_W
    clip_pts[:, 1] /= VB_H
    clip_d = " ".join(
        ([f"M {clip_pts[0,0]:.4f},{clip_pts[0,1]:.4f}"]
         + [f"L {p[0]:.4f},{p[1]:.4f}" for p in clip_pts[1:]]
         + ["Z"])
    )
    front2, n_clip = re.subn(
        r'(<clipPath id="wbc-art-clip"[^>]*>\s*<path d=")[^"]+(")',
        rf"\1{clip_d}\2",
        front2,
        count=1,
        flags=re.S,
    )
    FRONT.write_text(front2, encoding="utf-8")
    print("patched front", n_outer, n_inner, n_clip)

    MASK.write_text(
        '<?xml version="1.0" encoding="UTF-8"?>\n'
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 460" preserveAspectRatio="none">\n'
        f'  <path fill="#fff" d="{outer_d}"/>\n'
        "</svg>\n",
        encoding="utf-8",
    )
    print("wrote", MASK)

    # Preview overlay
    preview = Image.new("RGBA", (360, 460), (238, 228, 208, 255))
    draw = ImageDraw.Draw(preview)
    poly = [(float(x), float(y)) for x, y in outer_pts]
    draw.polygon(poly, fill=(90, 70, 50, 80), outline=(138, 109, 61, 255))
    ipoly = [(float(x), float(y)) for x, y in inner_pts]
    draw.line(ipoly + [ipoly[0]], fill=(180, 150, 100, 255), width=1)
    preview.save(ROOT / "_brain_rebuild_preview.png")

    colors = sample_ref_colors(REF)
    print("colors", colors)

    css = CSS.read_text(encoding="utf-8")
    # Force art section palette
    replacements = [
        (r"(\.wbc-art \{\n  background: )#[0-9a-fA-F]{3,8};", rf"\1{colors['bg']};"),
        (
            r"(\.wbc-art-copy \.wbc-kicker \{\n  margin-bottom: 18px;\n  color: )#[0-9a-fA-F]{3,8};",
            rf"\1{colors['text']};",
        ),
        (
            r"(\.wbc-art-copy h1 \{\n  margin: 0 0 22px;\n  color: )#[0-9a-fA-F]{3,8};",
            rf"\1{colors['text']};",
        ),
        (
            r"(\.wbc-art-cta \{\n(?:.*\n)*?  border: 1px solid )#[0-9a-fA-F]{3,8};(\n  color: )#[0-9a-fA-F]{3,8};",
            rf"\1{colors['text']};\2{colors['text']};",
        ),
        (r"(\.wbc-art-stroke \{\n  fill: none;\n  stroke: )#[0-9a-fA-F]{3,8};", rf"\1{colors['stroke']};"),
        (
            r"(\.wbc-art-icons \{\n(?:.*\n)*?  border-top: 1px solid )rgba?\([^)]+\);",
            rf"\1color-mix(in srgb, {colors['text']} 22%, transparent);",
        ),
        (
            r"(\.wbc-art-icons span \{\n(?:.*\n)*?  color: )#[0-9a-fA-F]{3,8};",
            rf"\1{colors['text']};",
        ),
    ]
    for pat, repl in replacements:
        css2, n = re.subn(pat, repl, css, count=1, flags=re.M)
        print("css", pat[:40], n)
        css = css2

    # Ensure stroke + art bg/text/cta more robustly with simpler replaces
    css = re.sub(
        r"\.wbc-art \{\n  background: #[0-9a-fA-F]+;",
        f".wbc-art {{\n  background: {colors['bg']};",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-copy \.wbc-kicker \{\n  margin-bottom: 18px;\n  color: )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['text']};",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-copy h1 \{\n  margin: 0 0 22px;\n  color: )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['text']};",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-cta \{[^}]*?border: 1px solid )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['text']};",
        css,
        count=1,
        flags=re.S,
    )
    css = re.sub(
        r"(\.wbc-art-cta \{[^}]*?color: )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['text']};",
        css,
        count=1,
        flags=re.S,
    )
    css = re.sub(
        r"(\.wbc-art-stroke \{\n  fill: none;\n  stroke: )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['stroke']};",
        css,
        count=1,
    )
    # icon color if present
    css = re.sub(
        r"(\.wbc-art-icons span \{\n(?:[^\n]*\n)*?\s*color: )#[0-9a-fA-F]+;",
        rf"\g<1>{colors['text']};",
        css,
        count=1,
    )
    CSS.write_text(css, encoding="utf-8")

    funcs = FUNCS.read_text(encoding="utf-8")
    funcs2, n = re.subn(
        r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'[^']+'\s*\);",
        "define('WBC_THEME_VERSION', '3.0.0');",
        funcs,
        count=1,
    )
    FUNCS.write_text(funcs2, encoding="utf-8")
    print("version bump", n)
    print("done")


if __name__ == "__main__":
    main()
