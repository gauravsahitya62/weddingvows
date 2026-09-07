from pathlib import Path
import re

fp = Path(r"wp-content/themes/weddingsbychetanparihar/front-page.php")
t = fp.read_text(encoding="utf-8")

m = re.search(r"\$outer\s*=\s*'([^']+)'", t)
print("outer len", len(m.group(1)) if m else None)
if m:
    o = m.group(1)
    print("outer start", o[:90])
    print("outer end", o[-50:])
    print("Q count", o.count("Q"))
    print("L count", o.count(" L "))

m2 = re.search(r"\$inner\s*=\s*'([^']+)'", t)
if m2:
    i = m2.group(1)
    print("inner Q", i.count("Q"), "start", i[:70])

m3 = re.search(
    r'clipPath id="wbc-art-clip"[^>]*>\s*<path d="([^"]+)"', t, re.S
)
if m3:
    c = m3.group(1)
    print("clip Q", c.count("Q"), "start", c[:70])

mask = Path("wp-content/themes/weddingsbychetanparihar/assets/brand/brain-mask.svg")
print("mask exists", mask.exists(), "size", mask.stat().st_size if mask.exists() else 0)
if mask.exists():
    mt = mask.read_text(encoding="utf-8")
    print("mask snippet", mt[:220].replace("\n", " | "))

ver = Path("wp-content/themes/weddingsbychetanparihar/functions.php").read_text(
    encoding="utf-8"
)
vm = re.search(r"WBC_THEME_VERSION['\"],\s*['\"]([^'\"]+)", ver)
print("version", vm.group(1) if vm else "?")

# Check if current path looks like double-smoothed (starts near bottom)
if m:
    nums = [float(x) for x in re.findall(r"-?\d+(?:\.\d+)?", m.group(1))]
    print("num count", len(nums), "first pair", nums[:2], "ymin", min(nums[1::2]), "ymax", max(nums[1::2]))
