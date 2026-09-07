from pathlib import Path
import re

theme = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar")
fp = (theme / "front-page.php").read_text(encoding="utf-8")
css = (theme / "assets/css/site.css").read_text(encoding="utf-8")
fn = (theme / "functions.php").read_text(encoding="utf-8")
mask = (theme / "assets/brand/brain-mask.svg").read_text(encoding="utf-8")

outer = re.search(r"\$outer='(M[^']{0,90})", fp)
inner = re.search(r"\$inner='(M[^']{0,90})", fp)
clip = re.search(r'id="wbc-art-clip"[^>]*>\s*<path d="(M[^"]{0,90})', fp, re.S)
print("outer", outer.group(1) if outer else None)
print("inner", inner.group(1) if inner else None)
print("clip ", clip.group(1) if clip else None)
print("mask ", mask[:160].replace("\n", " "))
print("ver  ", re.search(r"define\('WBC_THEME_VERSION', '([^']+)'", fn).group(1))
for label, pat in [
    ("bg", r"\.wbc-art \{\n  background: (#[0-9a-fA-F]+)"),
    ("h1", r"\.wbc-art-copy h1 \{\n(?:.*\n)*?  color: (#[0-9a-fA-F]+)"),
    ("stroke", r"\.wbc-art-stroke \{\n  fill: none;\n  stroke: (#[0-9a-fA-F]+)"),
]:
    m = re.search(pat, css)
    print(label, m.group(1) if m else "MISS")
