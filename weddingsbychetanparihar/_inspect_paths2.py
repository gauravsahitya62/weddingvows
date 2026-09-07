# -*- coding: utf-8 -*-
from pathlib import Path
import re

fp = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar\front-page.php")
t = fp.read_text(encoding="utf-8")

# show outer assignment region
m = re.search(r"\$outer\s*=\s*'([^']*)'", t)
print("outer match", bool(m))
if m:
    print("FULL OUTER:")
    print(m.group(1))

# clip
print("\n--- clip region ---")
i = t.find("wbc-art-clip")
print(t[i : i + 600])

# also look at debug mask area - sample path extremes
if m:
    nums = [float(x) for x in re.findall(r"[-+]?\d*\.?\d+", m.group(1))]
    xs = nums[0::2]
    ys = nums[1::2]
    print("\nbbox", min(xs), min(ys), max(xs), max(ys))
    print("n coords", len(nums) // 2)
