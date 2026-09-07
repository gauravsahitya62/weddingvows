from pathlib import Path
import re

fp = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\front-page.php")
t = fp.read_text(encoding="utf-8")

outer = re.search(r"\$outer\s*=\s*'([^']+)'", t)
inner = re.search(r"\$inner\s*=\s*'([^']+)'", t)
clip = re.search(r'id="wbc-art-clip">\s*<path\s+d="([^"]+)"', t)
mask = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\assets\brand\brain-mask.svg")
mt = mask.read_text(encoding="utf-8") if mask.exists() else ""
mp = re.search(r'd="([^"]+)"', mt)

for name, m in [("outer", outer), ("inner", inner), ("clip", clip), ("mask", mp)]:
    p = m.group(1) if m else ""
    print(f"=== {name} ===")
    print("found", bool(m), "len", len(p))
    print("start", p[:140])
    print("Q", p.count("Q"), "L", p.count(" L "), "window_prefix", p.startswith("M 24.0,436.0"))
    print()

# CSS check
css = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\assets\css\site.css").read_text(encoding="utf-8")
for needle in ["#eee4d0", "#c5aa86", "#7f674a", "#13120d"]:
    print(needle, css.count(needle))

# functions version
fn = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\functions.php").read_text(encoding="utf-8")
print("version", re.search(r"Version:\s*([\d.]+)", fn).group(1) if re.search(r"Version:\s*([\d.]+)", fn) else "?")
print("debug exists", Path(r"d:\nikhil\weddingsbychetanparihar\_brain_trace_debug.png").exists())
