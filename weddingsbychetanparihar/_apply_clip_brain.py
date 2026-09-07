"""Sync outer/inner/mask from #wbc-art-clip (multi-lobed brain). Fix cream + muted gold."""
from __future__ import annotations

import re
from pathlib import Path

import numpy as np
from PIL import Image, ImageDraw

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FP = THEME / "front-page.php"
CSS = THEME / "assets" / "css" / "site.css"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
FN = THEME / "functions.php"
REF = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\assets"
    r"\c__Users_Asus_AppData_Roaming_Cursor_User_workspaceStorage_"
    r"793ad060b5b1740f1392a74d85beebef_images_image-75cf0807-e90b-430c-a226-1cbab9c741f2.png"
)

# Match the clip's natural aspect (y extends ~0.035–0.96 → ~501 in 520 units)
VB_W, VB_H = 360.0, 520.0
NUM = r"-?\d+(?:\.\d+)?"


def parse_q_path(d: str) -> list[tuple[float, float]]:
    tokens = re.findall(rf"[A-Za-z]|{NUM}", d)
    pts: list[tuple[float, float]] = []
    i = 0
    while i < len(tokens):
        t = tokens[i]
        if t in "Mm":
            i += 1
            while i + 1 < len(tokens) and re.fullmatch(NUM, tokens[i]):
                pts.append((float(tokens[i]), float(tokens[i + 1])))
                i += 2
        elif t in "Ll":
            i += 1
            while i + 1 < len(tokens) and re.fullmatch(NUM, tokens[i]):
                pts.append((float(tokens[i]), float(tokens[i + 1])))
                i += 2
        elif t in "Qq":
            i += 1
            while i + 3 < len(tokens) and re.fullmatch(NUM, tokens[i]):
                # keep endpoint of each Q segment
                pts.append((float(tokens[i + 2]), float(tokens[i + 3])))
                i += 4
        elif t in "Zz":
            i += 1
        else:
            i += 1
    return pts


def parse_q_segments(d: str) -> list[tuple[float, float, float, float, float, float]]:
    """Return list of (x0,y0,cx,cy,x1,y1) for each Q."""
    tokens = re.findall(rf"[A-Za-z]|{NUM}", d)
    segs = []
    i = 0
    cx = cy = None
    while i < len(tokens):
        t = tokens[i]
        if t in "Mm":
            i += 1
            cx, cy = float(tokens[i]), float(tokens[i + 1])
            i += 2
        elif t in "Qq":
            i += 1
            while i + 3 < len(tokens) and re.fullmatch(NUM, tokens[i]):
                c1x, c1y = float(tokens[i]), float(tokens[i + 1])
                x1, y1 = float(tokens[i + 2]), float(tokens[i + 3])
                segs.append((cx, cy, c1x, c1y, x1, y1))
                cx, cy = x1, y1
                i += 4
        elif t in "Zz":
            i += 1
        else:
            i += 1
    return segs


def scale_seg(seg, sx, sy):
    x0, y0, cx, cy, x1, y1 = seg
    return (x0 * sx, y0 * sy, cx * sx, cy * sy, x1 * sx, y1 * sy)


def segs_to_path(segs: list[tuple]) -> str:
    if not segs:
        return ""
    x0, y0, cx, cy, x1, y1 = segs[0]
    parts = [f"M{x0:.2f} {y0:.2f} Q{cx:.2f} {cy:.2f} {x1:.2f} {y1:.2f}"]
    for _, _, cx, cy, x1, y1 in segs[1:]:
        parts.append(f"Q{cx:.2f} {cy:.2f} {x1:.2f} {y1:.2f}")
    return " ".join(parts) + " Z"


def inset_segs(segs, amount: float):
    pts = []
    for x0, y0, cx, cy, x1, y1 in segs:
        pts.append((x0, y0))
    # centroid
    xs = [p[0] for p in pts]
    ys = [p[1] for p in pts]
    mx, my = sum(xs) / len(xs), sum(ys) / len(ys)

    def pull(x, y):
        dx, dy = x - mx, y - my
        n = (dx * dx + dy * dy) ** 0.5 or 1.0
        return x - amount * dx / n, y - amount * dy / n

    out = []
    for x0, y0, cx, cy, x1, y1 in segs:
        a = pull(x0, y0)
        c = pull(cx, cy)
        b = pull(x1, y1)
        out.append((a[0], a[1], c[0], c[1], b[0], b[1]))
    return out


def normalize_segs(segs, vb_w, vb_h):
    out = []
    for x0, y0, cx, cy, x1, y1 in segs:
        out.append(
            (
                x0 / vb_w,
                y0 / vb_h,
                cx / vb_w,
                cy / vb_h,
                x1 / vb_w,
                y1 / vb_h,
            )
        )
    return out


def segs_to_path_norm(segs) -> str:
    x0, y0, cx, cy, x1, y1 = segs[0]
    parts = [f"M {x0:.4f},{y0:.4f} Q {cx:.4f},{cy:.4f} {x1:.4f},{y1:.4f}"]
    for _, _, cx, cy, x1, y1 in segs[1:]:
        parts.append(f"Q {cx:.4f},{cy:.4f} {x1:.4f},{y1:.4f}")
    return " ".join(parts) + " Z"


def sample_gold(ref: Path) -> str:
    im = Image.open(ref).convert("RGB")
    a = np.asarray(im)
    h, w = a.shape[:2]
    # Sample right-side photo border region (bronze frame)
    crop = a[int(h * 0.25) : int(h * 0.55), int(w * 0.72) : int(w * 0.88)]
    # Prefer mid-luma browns
    r, g, b = crop[..., 0].astype(float), crop[..., 1].astype(float), crop[..., 2].astype(float)
    luma = 0.299 * r + 0.587 * g + 0.114 * b
    mask = (luma > 90) & (luma < 170) & (r > g) & (g > b - 20)
    if mask.sum() < 50:
        # fallback muted bronze
        return "#c5aa86"
    pts = crop[mask]
    med = np.median(pts, axis=0).astype(int)
    return f"#{med[0]:02x}{med[1]:02x}{med[2]:02x}"


def preview(segs, out: Path, gold: str):
    scale = 2
    w, h = int(VB_W * scale), int(VB_H * scale)
    im = Image.new("RGB", (w, h), (238, 228, 208))
    dr = ImageDraw.Draw(im)
    poly = []
    for x0, y0, cx, cy, x1, y1 in segs:
        # sample quadratic for preview
        for t in np.linspace(0, 1, 8):
            u = 1 - t
            x = u * u * x0 + 2 * u * t * cx + t * t * x1
            y = u * u * y0 + 2 * u * t * cy + t * t * y1
            poly.append((x * scale, y * scale))
    if len(poly) >= 3:
        dr.polygon(poly, outline=gold, fill=(180, 140, 100))
        # stroke thicker
        for i in range(len(poly)):
            a, b = poly[i], poly[(i + 1) % len(poly)]
            dr.line([a, b], fill=gold, width=3)
    im.save(out)
    print("preview", out)


def main():
    php = FP.read_text(encoding="utf-8")
    m = re.search(
        r'<clipPath id="wbc-art-clip"[^>]*>\s*<path\s+d="([^"]+)"',
        php,
        re.S,
    )
    if not m:
        raise SystemExit("clip not found")
    clip_d = m.group(1)
    segs_obb = parse_q_segments(clip_d)
    print("clip Q segs", len(segs_obb))
    if len(segs_obb) < 40:
        raise SystemExit("clip too short / not brain")

    segs = [scale_seg(s, VB_W, VB_H) for s in segs_obb]
    xs = [s[0] for s in segs] + [s[4] for s in segs]
    ys = [s[1] for s in segs] + [s[5] for s in segs]
    print("user bbox", min(xs), min(ys), max(xs), max(ys))

    outer = segs_to_path(segs)
    inner = segs_to_path(inset_segs(segs, 6.0))
    clip_norm = segs_to_path_norm(normalize_segs(segs, VB_W, VB_H))

    # Guard: reject window family
    if outer.startswith("M 24.0,436.0") or "M24.0 436.0" in outer:
        raise SystemExit("forbidden window path")

    php2 = re.sub(
        r"\$outer\s*=\s*'[^']*';",
        f"$outer = '{outer}';",
        php,
        count=1,
    )
    php2 = re.sub(
        r"\$inner\s*=\s*'[^']*';",
        f"$inner = '{inner}';",
        php2,
        count=1,
    )
    php2 = re.sub(
        r'(<clipPath id="wbc-art-clip"[^>]*>\s*<path\s+d=")[^"]+(")',
        rf"\1{clip_norm}\2",
        php2,
        count=1,
        flags=re.S,
    )
    # viewBox must match VB_H
    php2 = php2.replace('viewBox="0 0 360 460"', 'viewBox="0 0 360 520"')
    php2 = php2.replace('viewBox="0 0 360 480"', 'viewBox="0 0 360 520"')
    FP.write_text(php2, encoding="utf-8")
    print("wrote front-page outer/inner/clip/viewBox")

    MASK.write_text(
        f'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {int(VB_W)} {int(VB_H)}">'
        f'<path fill="#000" d="{outer}"/></svg>\n',
        encoding="utf-8",
    )
    print("wrote mask")

    gold = sample_gold(REF) if REF.exists() else "#c5aa86"
    # Prefer muted bronze if sampled too yellow/bright
    # Force reference-like antique bronze for strokes
    stroke = "#c5aa86"
    accent = "#7f674a"
    cream = "#eee4d0"
    print("gold sample", gold, "using stroke", stroke)

    css = CSS.read_text(encoding="utf-8")
    css = re.sub(
        r"(--wbc-art-cream:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{cream}",
        css,
        count=1,
    )
    # common cream backgrounds in art section
    css = css.replace("#f4efe6", cream).replace("#F4EFE6", cream)
    css = css.replace("#f5f0e6", cream).replace("#efe8d8", cream)
    # stroke vars if present
    if "--wbc-art-stroke" in css:
        css = re.sub(
            r"(--wbc-art-stroke:\s*)#[0-9a-fA-F]{3,8}",
            rf"\1{stroke}",
            css,
            count=1,
        )
    if "--wbc-art-accent" in css:
        css = re.sub(
            r"(--wbc-art-accent:\s*)#[0-9a-fA-F]{3,8}",
            rf"\1{accent}",
            css,
            count=1,
        )
    # direct stroke colors on art strokes
    css = re.sub(
        r"(\.wbc-art-stroke\.is-outer\s*\{[^}]*stroke:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{stroke}",
        css,
        count=1,
        flags=re.S,
    )
    css = re.sub(
        r"(\.wbc-art-stroke\.is-inner\s*\{[^}]*stroke:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{accent}",
        css,
        count=1,
        flags=re.S,
    )
    # section cream
    css = re.sub(
        r"(\.wbc-art\s*\{[^}]*background(?:-color)?:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{cream}",
        css,
        count=1,
        flags=re.S,
    )
    CSS.write_text(css, encoding="utf-8")
    print("patched css")

    fn = FN.read_text(encoding="utf-8")
    m = re.search(r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'([^']+)'\s*\)", fn)
    if m:
        cur = m.group(1)
        parts = cur.split(".")
        try:
            parts[-1] = str(int(parts[-1]) + 1)
            nxt = ".".join(parts)
        except ValueError:
            nxt = cur + ".1"
        fn = fn.replace(
            f"define('WBC_THEME_VERSION', '{cur}')",
            f"define('WBC_THEME_VERSION', '{nxt}')",
            1,
        )
        FN.write_text(fn, encoding="utf-8")
        print("version", cur, "->", nxt)

    # verify
    php3 = FP.read_text(encoding="utf-8")
    om = re.search(r"\$outer\s*=\s*'([^']+)'", php3)
    assert om and not om.group(1).startswith("M10.00 124")
    assert "viewBox=\"0 0 360 520\"" in php3
    print("outer start", om.group(1)[:80])
    print("Q count", om.group(1).count("Q"))
    preview(segs, ROOT / "_brain_rebuild_preview.png", stroke)
    print("DONE")


if __name__ == "__main__":
    main()
