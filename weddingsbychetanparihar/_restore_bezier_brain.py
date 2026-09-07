"""Restore smooth cubic brain path from git history and sync mask/strokes."""
from __future__ import annotations

import re
import subprocess
from pathlib import Path

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FRONT = THEME / "front-page.php"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
CSS = THEME / "assets" / "css" / "site.css"
FN = THEME / "functions.php"

VB_W, VB_H = 360.0, 460.0


def tokenize(d: str) -> list[str | float]:
    toks: list[str | float] = []
    for m in re.finditer(r"[MmLlHhVvCcSsQqTtAaZz]|[-+]?(?:\d*\.\d+|\d+)(?:[eE][-+]?\d+)?", d):
        t = m.group(0)
        if re.fullmatch(r"[MmLlHhVvCcSsQqTtAaZz]", t):
            toks.append(t)
        else:
            toks.append(float(t))
    return toks


def scale_path(d: str, sx: float, sy: float) -> str:
    out: list[str] = []
    i = 0
    toks = tokenize(d)
    while i < len(toks):
        t = toks[i]
        if isinstance(t, str):
            cmd = t
            out.append(cmd)
            i += 1
            if cmd in "Zz":
                continue
            while i < len(toks) and not isinstance(toks[i], str):
                nums: list[float] = []
                while i < len(toks) and not isinstance(toks[i], str) and len(nums) < 6:
                    nums.append(float(toks[i]))
                    i += 1
                # scale by command arity in pairs (x,y) for cubics/lines
                scaled: list[str] = []
                j = 0
                while j < len(nums):
                    if cmd in "Hh":
                        scaled.append(f"{nums[j] * sx:.5f}")
                        j += 1
                    elif cmd in "Vv":
                        scaled.append(f"{nums[j] * sy:.5f}")
                        j += 1
                    else:
                        # assume x,y pairs
                        if j + 1 >= len(nums):
                            break
                        scaled.append(f"{nums[j] * sx:.5f}")
                        scaled.append(f"{nums[j + 1] * sy:.5f}")
                        j += 2
                out.extend(scaled)
        else:
            i += 1
    return " ".join(out)


def inset_path(d: str, inset: float) -> str:
    """Simple radial inset toward bbox center for stroke outline."""
    xs: list[float] = []
    ys: list[float] = []
    toks = tokenize(d)
    i = 0
    pts: list[tuple[float, float]] = []
    cx = cy = 0.0
    while i < len(toks):
        t = toks[i]
        if isinstance(t, str):
            cmd = t
            i += 1
            if cmd in "Zz":
                continue
            nums: list[float] = []
            while i < len(toks) and not isinstance(toks[i], str):
                nums.append(float(toks[i]))
                i += 1
            j = 0
            while j < len(nums):
                if cmd in "Hh":
                    cx = nums[j]
                    pts.append((cx, cy))
                    j += 1
                elif cmd in "Vv":
                    cy = nums[j]
                    pts.append((cx, cy))
                    j += 1
                elif cmd in "MmLl":
                    cx, cy = nums[j], nums[j + 1]
                    pts.append((cx, cy))
                    j += 2
                elif cmd in "Cc":
                    # keep only end point for bbox; for inset we need all control points
                    for k in range(0, min(6, len(nums) - j), 2):
                        if j + k + 1 < len(nums):
                            pts.append((nums[j + k], nums[j + k + 1]))
                    if j + 5 < len(nums):
                        cx, cy = nums[j + 4], nums[j + 5]
                    j += 6
                else:
                    break
        else:
            i += 1
    if not pts:
        return d
    xs = [p[0] for p in pts]
    ys = [p[1] for p in pts]
    minx, maxx = min(xs), max(xs)
    miny, maxy = min(ys), max(ys)
    cx0 = (minx + maxx) / 2
    cy0 = (miny + maxy) / 2
    # scale toward center
    sx = 1.0 - (2 * inset) / (maxx - minx)
    sy = 1.0 - (2 * inset) / (maxy - miny)

    def map_xy(x: float, y: float) -> tuple[float, float]:
        return (cx0 + (x - cx0) * sx, cy0 + (y - cy0) * sy)

    out: list[str] = []
    i = 0
    toks = tokenize(d)
    while i < len(toks):
        t = toks[i]
        if isinstance(t, str):
            cmd = t
            out.append(cmd)
            i += 1
            if cmd in "Zz":
                continue
            nums: list[float] = []
            while i < len(toks) and not isinstance(toks[i], str):
                nums.append(float(toks[i]))
                i += 1
            j = 0
            mapped: list[str] = []
            while j < len(nums):
                if cmd in "Hh":
                    mapped.append(f"{map_xy(nums[j], cy0)[0]:.5f}")
                    j += 1
                elif cmd in "Vv":
                    mapped.append(f"{map_xy(cx0, nums[j])[1]:.5f}")
                    j += 1
                else:
                    if j + 1 >= len(nums):
                        break
                    nx, ny = map_xy(nums[j], nums[j + 1])
                    mapped.append(f"{nx:.5f}")
                    mapped.append(f"{ny:.5f}")
                    j += 2
            out.extend(mapped)
        else:
            i += 1
    return " ".join(out)


def extract_clip_from_text(t: str) -> str | None:
    m = re.search(
        r'id=["\']wbc-art-clip["\'][\s\S]*?<path[^>]*\sd=["\']([^"\']+)["\']',
        t,
    )
    return m.group(1) if m else None


def main() -> None:
    # Prefer git history bezier path
    r = subprocess.run(
        [
            "git",
            "-C",
            str(ROOT),
            "show",
            "8ebf688:wp-content/themes/weddingsbychetanparihar/front-page.php",
        ],
        capture_output=True,
        text=True,
    )
    hist = r.stdout
    clip = extract_clip_from_text(hist) if hist else None
    if not clip or ("C" not in clip and "c" not in clip):
        # fall back: search transcript / current file for long cubic path
        cur = FRONT.read_text(encoding="utf-8")
        clip = extract_clip_from_text(cur)
        print("hist ok", bool(hist), "clip cubic", clip and ("C" in clip or "c" in clip))

    if not clip:
        raise SystemExit("no clip path found")

    print("clip len", len(clip), "hasC", "C" in clip or "c" in clip)
    print("clip start", clip[:160])

    # objectBoundingBox path is already 0..1 — keep as clip
    clip_norm = clip.strip()

    # Absolute stroke paths in 360x460
    outer = scale_path(clip_norm, VB_W, VB_H)
    inner = inset_path(outer, 7.0)

    print("outer start", outer[:120])
    print("outer hasC", "C" in outer or "c" in outer)

    front = FRONT.read_text(encoding="utf-8")

    # Replace clipPath path
    front2, n1 = re.subn(
        r'(id="wbc-art-clip"[\s\S]*?<path[^>]*\sd=")[^"]+(")',
        rf"\g<1>{clip_norm}\2",
        front,
        count=1,
    )
    # Replace $outer / $inner PHP strings
    front2, n2 = re.subn(
        r"(\$outer\s*=\s*')[^']*(')",
        rf"\g<1>{outer}\2",
        front2,
        count=1,
    )
    front2, n3 = re.subn(
        r"(\$inner\s*=\s*')[^']*(')",
        rf"\g<1>{inner}\2",
        front2,
        count=1,
    )
    FRONT.write_text(front2, encoding="utf-8")
    print("patched front", n1, n2, n3)

    # brain-mask.svg — white fill on black, absolute coords matching viewBox
    mask = f'''<?xml version="1.0" encoding="UTF-8"?>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 {int(VB_W)} {int(VB_H)}" preserveAspectRatio="none">
  <path fill="#fff" d="{outer}"/>
</svg>
'''
    MASK.write_text(mask, encoding="utf-8")
    print("wrote mask", MASK)

    # Exact colors from reference sample
    colors = {
        "bg": "#eee4d0",
        "text": "#83684b",
        "stroke": "#9e7650",
        "muted": "#6a5a48",
    }
    css = CSS.read_text(encoding="utf-8")
    replacements = [
        (r"(\.wbc-art\s*\{[^}]*background:\s*)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['bg']}"),
        (r"(\.wbc-art-kicker[^}]*color:\s*)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['text']}"),
        (r"(\.wbc-art-copy\s+h1[^}]*color:\s*)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['text']}"),
        (r"(\.wbc-art-cta[^}]*border:[^;]*?)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['stroke']}"),
        (r"(\.wbc-art-cta[^}]*color:\s*)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['text']}"),
        (r"(\.wbc-art-arch[^}]*stroke:\s*)#[0-9a-fA-F]{3,8}", rf"\g<1>{colors['stroke']}"),
    ]
    for pat, rep in replacements:
        css, n = re.subn(pat, rep, css, count=1, flags=re.S)
        print("css", pat[:40], n)
    # icons
    css, n = re.subn(
        r"(\.wbc-art-icons[^}]*border-top:[^;]*?)#[0-9a-fA-F]{3,8}",
        rf"\g<1>{colors['stroke']}",
        css,
        count=1,
        flags=re.S,
    )
    print("css icons border", n)
    css, n = re.subn(
        r"(\.wbc-art-icons[^}]*color:\s*)#[0-9a-fA-F]{3,8}",
        rf"\g<1>{colors['muted']}",
        css,
        count=1,
        flags=re.S,
    )
    print("css icons color", n)
    # ensure section bg
    css, n = re.subn(
        r"(\.wbc-art\s*\{[^}]*?background:\s*)[^;]+",
        rf"\g<1>{colors['bg']}",
        css,
        count=1,
        flags=re.S,
    )
    print("css bg force", n)
    CSS.write_text(css, encoding="utf-8")

    # bump version
    fn = FN.read_text(encoding="utf-8")
    m = re.search(r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'([^']+)'\s*\)", fn)
    if m:
        parts = m.group(1).split(".")
        parts[-1] = str(int(parts[-1]) + 1)
        ver = ".".join(parts)
        fn = fn.replace(m.group(0), f"define( 'WBC_THEME_VERSION', '{ver}' )")
        FN.write_text(fn, encoding="utf-8")
        print("version", ver)

    # quick preview with cairo if available
    try:
        import cairo

        W, H = 400, 520
        surf = cairo.ImageSurface(cairo.FORMAT_ARGB32, W, H)
        ctx = cairo.Context(surf)
        ctx.set_source_rgb(0xEE / 255, 0xE4 / 255, 0xD0 / 255)
        ctx.paint()
        ctx.scale(W / VB_W, H / VB_H)

        def path_to_cairo(d: str) -> None:
            toks = tokenize(d)
            i = 0
            while i < len(toks):
                t = toks[i]
                if isinstance(t, str):
                    cmd = t
                    i += 1
                    if cmd in "Zz":
                        ctx.close_path()
                        continue
                    nums: list[float] = []
                    while i < len(toks) and not isinstance(toks[i], str):
                        nums.append(float(toks[i]))
                        i += 1
                    j = 0
                    while j < len(nums):
                        if cmd == "M":
                            ctx.move_to(nums[j], nums[j + 1])
                            j += 2
                            cmd = "L"
                        elif cmd == "L":
                            ctx.line_to(nums[j], nums[j + 1])
                            j += 2
                        elif cmd == "C":
                            ctx.curve_to(
                                nums[j],
                                nums[j + 1],
                                nums[j + 2],
                                nums[j + 3],
                                nums[j + 4],
                                nums[j + 5],
                            )
                            j += 6
                        else:
                            break

        path_to_cairo(outer)
        ctx.set_source_rgb(0.2, 0.15, 0.1)
        ctx.fill_preserve()
        ctx.set_source_rgb(0x9E / 255, 0x76 / 255, 0x50 / 255)
        ctx.set_line_width(2.2)
        ctx.stroke()
        path_to_cairo(inner)
        ctx.set_source_rgb(0x83 / 255, 0x68 / 255, 0x4B / 255)
        ctx.set_line_width(1.4)
        ctx.stroke()
        outp = ROOT / "_brain_bezier_preview.png"
        surf.write_to_png(str(outp))
        print("preview", outp)
    except Exception as e:
        print("preview skip", e)


if __name__ == "__main__":
    main()
