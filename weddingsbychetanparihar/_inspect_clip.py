from pathlib import Path
import re

php = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\front-page.php").read_text(encoding="utf-8")
m = re.search(r'id="wbc-art-clip".*?d="([^"]+)"', php, re.S)
print("found", bool(m))
if m:
    d = m.group(1)
    print("len", len(d), "Q", d.count("Q"), "L", d.count(" L "))
    print("start", d[:300])
    print("end", d[-200:])
    nums = [float(x) for x in re.findall(r"[-+]?\d*\.?\d+(?:[eE][-+]?\d+)?", d)]
    xs = nums[0::2]
    ys = nums[1::2]
    print("n coords", len(nums)//2)
    print("obb bbox", min(xs), min(ys), max(xs), max(ys))
    print("user bbox", min(xs)*360, min(ys)*520, max(xs)*360, max(ys)*520)
