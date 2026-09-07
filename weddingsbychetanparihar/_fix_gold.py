from pathlib import Path
import re

ROOT = Path(r"d:/nikhil/weddingsbychetanparihar")
css = ROOT / "wp-content/themes/weddingsbychetanparihar/assets/css/site.css"
t = css.read_text(encoding="utf-8")

t = t.replace(
    ".wbc-art-copy h1 {\n  margin: 0;\n  color: #13120d;",
    ".wbc-art-copy h1 {\n  margin: 0;\n  color: #7f674a;",
)
t = t.replace(
    "margin-top: 1.35rem;\n  padding: 0.72rem 1.15rem;\n  color: #13120d;\n  border: 1px solid #7f674a;",
    "margin-top: 1.35rem;\n  padding: 0.72rem 1.15rem;\n  color: #7f674a;\n  border: 1px solid #7f674a;",
)
t = t.replace("aspect-ratio: 360 / 460;", "aspect-ratio: 360 / 520;")
t = t.replace("stroke: #c5aa86;", "stroke: #aa7f58;")
css.write_text(t, encoding="utf-8")
print("css updated")

fn = ROOT / "wp-content/themes/weddingsbychetanparihar/functions.php"
ft = fn.read_text(encoding="utf-8")
ft2, n = re.subn(
    r"define\('WBC_THEME_VERSION',\s*'[^']+'\);",
    "define('WBC_THEME_VERSION', '3.0.4');",
    ft,
    count=1,
)
fn.write_text(ft2, encoding="utf-8")
print("version", n)

# verify
css_t = css.read_text(encoding="utf-8")
for needle in ["color: #7f674a;", "aspect-ratio: 360 / 520;", "stroke: #aa7f58;"]:
    print(needle, css_t.count(needle))
print("ver", "3.0.4" in fn.read_text(encoding="utf-8"))
