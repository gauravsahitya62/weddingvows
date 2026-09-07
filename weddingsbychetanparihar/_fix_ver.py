from pathlib import Path
import re

ROOT = Path(r"d:/nikhil/weddingsbychetanparihar")
fn = ROOT / "wp-content/themes/weddingsbychetanparihar/functions.php"
ft = fn.read_text(encoding="utf-8")
ft2, n = re.subn(
    r"define\(\s*'WBC_THEME_VERSION'\s*,\s*'[^']+'\s*\);",
    "define( 'WBC_THEME_VERSION', '3.0.4' );",
    ft,
    count=1,
)
fn.write_text(ft2, encoding="utf-8")
print("version replacements", n)
print("now", re.search(r"WBC_THEME_VERSION',\s*'([^']+)'", fn.read_text(encoding="utf-8")).group(1))

css = (ROOT / "wp-content/themes/weddingsbychetanparihar/assets/css/site.css").read_text(encoding="utf-8")
# show art section colors
for label, pat in [
    ("h1", r"\.wbc-art-copy h1 \{[^}]+\}"),
    ("cta", r"\.wbc-art-cta \{[^}]+\}"),
    ("photo", r"\.wbc-art-photo \{[^}]+\}"),
    ("stroke", r"stroke:\s*#[0-9a-fA-F]+"),
]:
    m = re.search(pat, css, re.S)
    print("---", label)
    print(m.group(0)[:280] if m else "MISSING")
