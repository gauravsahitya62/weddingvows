# -*- coding: utf-8 -*-
from pathlib import Path
import re

roots = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts")
starts = {}
color_hits = []

for p in roots.rglob("*.jsonl"):
    with p.open(encoding="utf-8", errors="ignore") as f:
        for i, line in enumerate(f, 1):
            if "outer" in line and ("front-page" in line or "$outer" in line or "\\$outer" in line):
                text = (
                    line.replace("\\\\n", "\n")
                    .replace("\\n", "\n")
                    .replace("\\'", "'")
                    .replace("\\$", "$")
                )
                for m in re.finditer(r"\$outer\s*=\s*'([^']{15,60})", text):
                    s = m.group(1)[:48]
                    if s not in starts:
                        starts[s] = f"{p.parent.name[:8]}:{i}"
            if "wbc-art" in line:
                for c in (
                    "#13120d",
                    "#7f674a",
                    "#c5aa86",
                    "#aa7f58",
                    "#735539",
                    "#a67d47",
                    "#7a5a3d",
                    "#c9a227",
                    "#b08d57",
                ):
                    if c in line:
                        color_hits.append((f"{p.parent.name[:8]}:{i}", c))

print("OUTER STARTS:")
for s, loc in starts.items():
    print(loc, s)

print("\nCOLOR HITS (unique):")
seen = set()
for loc, c in color_hits:
    key = (c, loc.split(":")[0])
    if key in seen:
        continue
    seen.add(key)
    print(loc, c)
