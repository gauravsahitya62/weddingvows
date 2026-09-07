from pathlib import Path
import re

front = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\front-page.php").read_text(encoding="utf-8", errors="ignore")
m = re.search(r"\$outer\s*=\s*'([^']+)'", front)
if not m:
    print("outer not found")
else:
    d = m.group(1)
    print("outer len", len(d))
    print("Q count", d.count(" Q "))
    print("L count", d.count(" L "))
    print("starts", d[:120])
    # extract coords
    nums = [float(x) for x in re.findall(r"[-+]?\d*\.?\d+(?:[eE][-+]?\d+)?", d)]
    xs = nums[0::2]
    ys = nums[1::2]
    print("points", len(xs), "bbox", min(xs), min(ys), max(xs), max(ys))

# check clip
mc = re.search(r'clipPath id="wbc-art-clip"[^>]*>\s*<path d="([^"]+)"', front, re.S)
if mc:
    d = mc.group(1)
    print("clip Q", d.count(" Q "), "L", d.count(" L "), "len", len(d))
    nums = [float(x) for x in re.findall(r"[-+]?\d*\.?\d+(?:[eE][-+]?\d+)?", d)]
    print("clip nums", len(nums))

# find ref image
roots = [
    Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"),
    Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"),
]
for r in roots:
    if r.exists():
        print("root", r)
        for p in r.rglob("*.png"):
            if "75cf0807" in p.name or "brain" in p.name.lower() or "image-" in p.name:
                print(" png", p, p.stat().st_size)
