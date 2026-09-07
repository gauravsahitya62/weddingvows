"""Trace brain cutout silhouette from reference PNG and update theme assets."""
from __future__ import annotations

import re
from pathlib import Path

import cv2
import numpy as np
from PIL import Image

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FRONT = THEME / "front-page.php"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
FUNCS = THEME / "functions.php"
CSS = THEME / "assets" / "css" / "site.css"

REF = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\assets"
    r"\c__Users_Asus_AppData_Roaming_Cursor_User_workspaceStorage_"
    r"793ad060b5b1740f1392a74d85beebef_images_image-75cf0807-e90b-430c-a226-1cbab9c741f2.png"
)
OUT_DEBUG = ROOT / "_brain_trace_debug.png"
VIEW_W, VIEW_H = 360, 460


def sample_gold_colors(rgb: np.ndarray) -> dict[str, str]:
    """Sample stroke gold and text brown from reference."""
    h, w = rgb.shape[:2]
    cream = np.array([238.0, 228.0, 208.0])
    # Right half: find bronze border pixels (yellowish-brown, not cream, not photo-dark)
    right = rgb[:, w // 2 :]
    dist = np.linalg.norm(right.astype(float) - cream, axis=2)
    # Border candidates: mid-brightness warm tones
    r, g, b = right[:, :, 0], right[:, :, 1], right[:, :, 2]
    warm = (r.astype(int) > g.astype(int) + 8) & (r.astype(int) > b.astype(int) + 20)
    mid = (r > 90) & (r < 210) & (g > 60) & (g < 180)
    border = (dist > 30) & (dist < 120) & warm & mid
    stroke = "#c4a574"
    if border.any():
        mean = right[border].mean(axis=0).astype(int)
        stroke = f"#{mean[0]:02x}{mean[1]:02x}{mean[2]:02x}"
    # Left text: dark brown
    left = rgb[:, : w // 2]
    dark = (left[:, :, 0] < 90) & (left[:, :, 1] < 80) & (left[:, :, 2] < 70)
    text = "#3a2a1c"
    if dark.any():
        mean = left[dark].mean(axis=0).astype(int)
        text = f"#{mean[0]:02x}{mean[1]:02x}{mean[2]:02x}"
    # Accent / kicker mid gold
    accent = "#8a6d3d"
    mid_text = (
        (left[:, :, 0] > 100)
        & (left[:, :, 0] < 170)
        & (left[:, :, 1] > 70)
        & (left[:, :, 1] < 130)
        & (left[:, :, 2] < 100)
    )
    if mid_text.any():
        mean = left[mid_text].mean(axis=0).astype(int)
        accent = f"#{mean[0]:02x}{mean[1]:02x}{mean[2]:02x}"
    return {"stroke": stroke, "text": text, "accent": accent}


def isolate_cutout(rgb: np.ndarray) -> tuple[np.ndarray, tuple[int, int, int, int]]:
    """Return binary mask of cutout (white=inside) and bbox in full image."""
    h, w = rgb.shape[:2]
    cream = np.array([238.0, 228.0, 208.0])
    # Focus on right 55%
    x0 = int(w * 0.42)
    crop = rgb[:, x0:]
    dist = np.linalg.norm(crop.astype(float) - cream, axis=2)
    # Non-cream = cutout + borders + shadows
    binary = (dist > 18).astype(np.uint8) * 255
    # Clean
    kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
    binary = cv2.morphologyEx(binary, cv2.MORPH_CLOSE, kernel, iterations=2)
    binary = cv2.morphologyEx(binary, cv2.MORPH_OPEN, kernel, iterations=1)
    # Largest contour
    contours, _ = cv2.findContours(binary, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
    if not contours:
        raise RuntimeError("No cutout contour found")
    cnt = max(contours, key=cv2.contourArea)
    mask = np.zeros_like(binary)
    cv2.drawContours(mask, [cnt], -1, 255, -1)
    # Slight erode to sit inside gold border (photo fill, not border)
    mask = cv2.erode(mask, cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (7, 7)), iterations=1)
    ys, xs = np.where(mask > 0)
    x1, x2 = int(xs.min()), int(xs.max())
    y1, y2 = int(ys.min()), int(ys.max())
    # pad
    pad = 4
    x1 = max(0, x1 - pad)
    y1 = max(0, y1 - pad)
    x2 = min(mask.shape[1] - 1, x2 + pad)
    y2 = min(mask.shape[0] - 1, y2 + pad)
    return mask, (x0 + x1, y1, x0 + x2, y2)


def contour_to_viewbox(cnt: np.ndarray, bbox: tuple[int, int, int, int]) -> np.ndarray:
    """Map contour points from image px to 360x460 viewBox with margin."""
    x0, y0, x1, y1 = bbox
    bw, bh = x1 - x0, y1 - y0
    # Fit into viewBox with ~4% margin
    mx, my = VIEW_W * 0.04, VIEW_H * 0.03
    pts = cnt.reshape(-1, 2).astype(float)
    # Contour is in crop coords relative to full image if we offset
    # Our cnt is relative to the mask which starts at x0 of crop... 
    # Actually mask is crop-sized; cnt from mask. So add x0 of crop when building bbox.
    # bbox is already in full-image coords. Contour points are in mask (crop) coords.
    # Wait - isolate_cutout returns mask of crop size, and bbox in full image.
    # Contour from mask is in crop coordinates. Convert:
    # full_x = x0_crop + local_x, but bbox[0] = x0_crop + local_x1
    # Easier: remake contour from full-image mask
    return pts  # placeholder; caller handles


def mask_to_path(full_mask: np.ndarray) -> tuple[str, str]:
    """Trace full-image mask and return outer path + slightly inset path in viewBox coords."""
    contours, _ = cv2.findContours(full_mask, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
    cnt = max(contours, key=cv2.contourArea)
    # Smooth / simplify
    peri = cv2.arcLength(cnt, True)
    approx = cv2.approxPolyDP(cnt, 0.0018 * peri, True)
    if len(approx) < 24:
        approx = cv2.approxPolyDP(cnt, 0.0012 * peri, True)
    # Resample for nicer curves
    pts = approx.reshape(-1, 2).astype(float)
    x0, y0 = pts[:, 0].min(), pts[:, 1].min()
    x1, y1 = pts[:, 0].max(), pts[:, 1].max()
    bw, bh = max(1.0, x1 - x0), max(1.0, y1 - y0)
    # Map to viewBox with margin
    mx, my = 10.0, 8.0
    scale = min((VIEW_W - 2 * mx) / bw, (VIEW_H - 2 * my) / bh)
    # Center
    ox = (VIEW_W - bw * scale) / 2
    oy = (VIEW_H - bh * scale) / 2

    def map_pts(p: np.ndarray) -> np.ndarray:
        out = np.empty_like(p)
        out[:, 0] = (p[:, 0] - x0) * scale + ox
        out[:, 1] = (p[:, 1] - y0) * scale + oy
        return out

    mapped = map_pts(pts)

    def to_smooth_path(points: np.ndarray) -> str:
        # Catmull-Rom style quadratic smoothing via midpoints
        n = len(points)
        if n < 3:
            return ""
        parts = [f"M{points[0,0]:.2f} {points[0,1]:.2f}"]
        for i in range(n):
            p0 = points[i]
            p1 = points[(i + 1) % n]
            mid = (p0 + p1) / 2
            parts.append(f"Q{p0[0]:.2f} {p0[1]:.2f} {mid[0]:.2f} {mid[1]:.2f}")
        parts.append("Z")
        return " ".join(parts)

    outer = to_smooth_path(mapped)

    # Inset for inner stroke / clip: shrink toward centroid ~2.5%
    c = mapped.mean(axis=0)
    inset = c + (mapped - c) * 0.955
    inner = to_smooth_path(inset)
    return outer, inner


def build_full_mask(rgb: np.ndarray) -> np.ndarray:
    cream = np.array([238.0, 228.0, 208.0])
    h, w = rgb.shape[:2]
    x0 = int(w * 0.42)
    crop = rgb[:, x0:]
    dist = np.linalg.norm(crop.astype(float) - cream, axis=2)
    binary = (dist > 18).astype(np.uint8) * 255
    kernel = cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (5, 5))
    binary = cv2.morphologyEx(binary, cv2.MORPH_CLOSE, kernel, iterations=3)
    binary = cv2.morphologyEx(binary, cv2.MORPH_OPEN, kernel, iterations=1)
    contours, _ = cv2.findContours(binary, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
    cnt = max(contours, key=cv2.contourArea)
    mask_crop = np.zeros_like(binary)
    cv2.drawContours(mask_crop, [cnt], -1, 255, -1)
    # Erode so fill sits inside gold double-border
    mask_crop = cv2.erode(
        mask_crop, cv2.getStructuringElement(cv2.MORPH_ELLIPSE, (9, 9)), iterations=2
    )
    full = np.zeros((h, w), np.uint8)
    full[:, x0:] = mask_crop
    return full


def write_mask_svg(path: str) -> None:
    svg = f'''<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {VIEW_W} {VIEW_H}" preserveAspectRatio="none">
  <path fill="#fff" d="{path}"/>
</svg>
'''
    MASK.write_text(svg, encoding="utf-8")


def patch_front_page(outer: str, inner: str) -> None:
    php = FRONT.read_text(encoding="utf-8")
    # Replace clipPath d=
    php2, n1 = re.subn(
        r'(<clipPath id="wbc-art-clip">\s*<path d=")([^"]+)(")',
        rf"\g<1>{outer}\3",
        php,
        count=1,
    )
    # Replace $outer = '...';
    php2, n2 = re.subn(
        r"(\$outer\s*=\s*')([^']+)(')",
        rf"\g<1>{outer}\3",
        php2,
        count=1,
    )
    php2, n3 = re.subn(
        r"(\$inner\s*=\s*')([^']+)(')",
        rf"\g<1>{inner}\3",
        php2,
        count=1,
    )
    if n1 + n2 + n3 < 2:
        raise RuntimeError(f"front-page patch failed n1={n1} n2={n2} n3={n3}")
    FRONT.write_text(php2, encoding="utf-8")
    print(f"Patched front-page.php (clip={n1}, outer={n2}, inner={n3})")


def patch_css_gold(colors: dict[str, str]) -> None:
    css = CSS.read_text(encoding="utf-8")
    # Keep background exact #eee4d0
    css = re.sub(
        r"(\.wbc-art \{\s*background:\s*)#[0-9a-fA-F]{3,8}",
        r"\1#eee4d0",
        css,
        count=1,
    )
    # Stroke gold from reference
    css = re.sub(
        r"(\.wbc-art-stroke \{\s*fill:\s*none;\s*stroke:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{colors['stroke']}",
        css,
        count=1,
    )
    # Heading / CTA text toward reference brown-gold
    css = re.sub(
        r"(\.wbc-art-copy h1 \{\n(?:.*\n)*?\s*color:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{colors['text']}",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-copy \.wbc-kicker \{\n(?:.*\n)*?\s*color:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{colors['accent']}",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-cta \{\n(?:.*\n)*?\s*border:\s*1px solid )#[0-9a-fA-F]{3,8}",
        rf"\1{colors['accent']}",
        css,
        count=1,
    )
    css = re.sub(
        r"(\.wbc-art-cta \{\n(?:.*\n)*?\s*color:\s*)#[0-9a-fA-F]{3,8}",
        rf"\1{colors['text']}",
        css,
        count=1,
    )
    CSS.write_text(css, encoding="utf-8")
    print(f"Patched CSS gold stroke={colors['stroke']} text={colors['text']} accent={colors['accent']}")


def bump_version() -> None:
    php = FUNCS.read_text(encoding="utf-8")
    m = re.search(r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'([^']+)'\s*\)", php)
    if not m:
        print("WARN: version define not found")
        return
    ver = m.group(1)
    parts = ver.split(".")
    parts[-1] = str(int(parts[-1]) + 1)
    new = ".".join(parts)
    php = php.replace(
        f"define('WBC_THEME_VERSION', '{ver}')",
        f"define('WBC_THEME_VERSION', '{new}')",
        1,
    )
    FUNCS.write_text(php, encoding="utf-8")
    print(f"Version {ver} -> {new}")


def main() -> None:
    if not REF.exists():
        raise SystemExit(f"Missing reference: {REF}")
    rgb = np.array(Image.open(REF).convert("RGB"))
    print("Reference", rgb.shape)
    colors = sample_gold_colors(rgb)
    print("Sampled colors", colors)

    full_mask = build_full_mask(rgb)
    # Debug overlay
    dbg = rgb.copy()
    dbg[full_mask > 0] = (dbg[full_mask > 0] * 0.5 + np.array([0, 180, 80]) * 0.5).astype(
        np.uint8
    )
    Image.fromarray(dbg).save(OUT_DEBUG)
    print("Wrote", OUT_DEBUG)

    outer, inner = mask_to_path(full_mask)
    print("Outer path length", len(outer), "Inner", len(inner))
    write_mask_svg(outer)
    print("Wrote", MASK)
    patch_front_page(outer, inner)
    patch_css_gold(colors)
    bump_version()
    print("Done")


if __name__ == "__main__":
    main()
