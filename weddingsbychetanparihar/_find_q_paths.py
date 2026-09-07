"""Find smooth Q-rich brain paths in the Cursor agent transcript and apply them."""
from __future__ import annotations

import re
from pathlib import Path

ROOT = Path(r"d:\nikhil\weddingsbychetanparihar")
THEME = ROOT / "wp-content" / "themes" / "weddingsbychetanparihar"
FP = THEME / "front-page.php"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
FN = THEME / "functions.php"
TRANS = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"
    r"\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911"
    r"\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)

# Absolute-ish SVG path with many Q segments (prefer ~44)
PATH_RE = re.compile(
    r"M\s*-?\d+(?:\.\d+)?\s*,\s*-?\d+(?:\.\d+)?(?:\s+[A-Za-z][^A-Za-z]*)*?Z",
    re.I | re.S,
)


def parse_abs(d: str):
    tokens = re.findall(r"[A-Za-z]|-?\d+(?:\.\d+)?", d)
    i = 0
    pts = []
    cx = cy = None
    while i < len(tokens):
        t = tokens[i]
        if t.isalpha():
            cmd = t.upper()
            i += 1
            if cmd == "Z":
                break
            if cmd == "M":
                cx, cy = float(tokens[i]), float(tokens[i + 1])
                pts.append((cx, cy))
                i += 2
            elif cmd == "L":
                cx, cy = float(tokens[i]), float(tokens[i + 1])
                pts.append((cx, cy))
                i += 2
            elif cmd == "Q":
                # skip control, take end
                i += 2
                cx, cy = float(tokens[i]), float(tokens[i + 1])
                pts.append((cx, cy))
                i += 2
            else:
                break
        else:
            i += 1
    return pts


def shrink(d: str, s: float = 0.965) -> str:
    tokens = re.findall(r"[A-Za-z]|-?\d+(?:\.\d+)?", d)
    out = []
    i = 0
    while i < len(tokens):
        t = tokens[i]
        if t.isalpha():
            out.append(t.upper())
            i += 1
            n = 0 if t.upper() == "Z" else (2 if t.upper() in "ML" else 4 if t.upper() == "Q" else 0)
            for _ in range(n):
                v = float(tokens[i])
                out.append(f"{180 + (v - 180) * s:.1f}")
                i += 1
        else:
            i += 1
    return " ".join(out)


def to_clip(d: str) -> str:
    tokens = re.findall(r"[A-Za-z]|-?\d+(?:\.\d+)?", d)
    out = []
    i = 0
    while i < len(tokens):
        t = tokens[i]
        if t.isalpha():
            out.append(t.upper())
            i += 1
            n = 0 if t.upper() == "Z" else (2 if t.upper() in "ML" else 4 if t.upper() == "Q" else 0)
            for j in range(n):
                v = float(tokens[i])
                out.append(f"{(v / 360 if j % 2 == 0 else v / 460):.4f}")
                i += 1
        else:
            i += 1
    return " ".join(out)


def main() -> None:
    best = None
    with TRANS.open("r", encoding="utf-8", errors="ignore") as f:
        for i, line in enumerate(f):
            if line.count("Q ") < 30:
                continue
            for m in PATH_RE.finditer(line):
                d = re.sub(r"\s+", " ", m.group(0)).strip()
                # Prefer absolute pixel coords (not 0–1 clip units)
                if "0.0" in d[:20] and d.startswith("M 0."):
                    continue
                qn = d.count("Q ")
                if qn < 30:
                    continue
                pts = parse_abs(d)
                if len(pts) < 20:
                    continue
                xs = [p[0] for p in pts]
                ys = [p[1] for p in pts]
                if max(xs) - min(xs) < 100 or max(ys) - min(ys) < 100:
                    continue
                score = qn * 10 + len(pts)
                # Prefer ~44 Q
                score -= abs(qn - 44) * 3
                print(f"line {i}: Q={qn} pts={len(pts)} score={score} start={d[:70]}")
                if best is None or score > best[0]:
                    best = (score, i, qn, d)

    if not best:
        raise SystemExit("No suitable path found")

    score, line_no, qn, outer = best
    print(f"\nSELECTED line {line_no} Q={qn} score={score}")
    print(outer[:160], "...")

    # Ensure ends with Z
    if not outer.endswith("Z"):
        outer = outer.rstrip() + " Z"

    inner = shrink(outer)
    clip = to_clip(outer)

    text = FP.read_text(encoding="utf-8")
    text2, n1 = re.subn(
        r"(\$outer\s*=\s*')([^']+)(')",
        lambda m: m.group(1) + outer + m.group(3),
        text,
        count=1,
    )
    text2, n2 = re.subn(
        r"(\$inner\s*=\s*')([^']+)(')",
        lambda m: m.group(1) + inner + m.group(3),
        text2,
        count=1,
    )
    text2, n3 = re.subn(
        r'(id="wbc-art-clip">\s*<path\s+d=")([^"]+)(")',
        lambda m: m.group(1) + clip + m.group(3),
        text2,
        count=1,
    )
    if n1 != 1 or n2 != 1 or n3 != 1:
        raise SystemExit(f"front-page replace failed: {n1=} {n2=} {n3=}")
    FP.write_text(text2, encoding="utf-8")

    MASK.write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 460" preserveAspectRatio="none">\n'
        f'  <path fill="#fff" d="{outer}"/>\n'
        "</svg>\n",
        encoding="utf-8",
    )

    fn = FN.read_text(encoding="utf-8")
    fn2, n4 = re.subn(
        r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'[^']*'\s*\)",
        "define( 'WBC_THEME_VERSION', '3.0.2' )",
        fn,
        count=1,
    )
    if n4 != 1:
        raise SystemExit("version bump failed")
    FN.write_text(fn2, encoding="utf-8")

    css = (THEME / "assets" / "css" / "site.css").read_text(encoding="utf-8")
    assert "#eee4d0" in css
    print("Applied smooth Q brain path + version 3.0.2")


if __name__ == "__main__":
    main()
