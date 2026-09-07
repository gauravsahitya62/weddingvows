# -*- coding: utf-8 -*-
"""Extract the first full wbc-art section CSS and outer path from transcript line ~564-600."""
from pathlib import Path
import json
import re

p = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts"
    r"\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)

# Also check 2c62 and 94731
for name in [
    "f4466360-b215-4174-9d88-0da5d153d911",
    "2c62fcf3-62d8-4248-aeb1-27cadd1fca74",
    "94731fc8-cbc6-457d-a433-777e4c857a8d",
    "0209e9d0-f0ce-4851-974d-64afb82d9667",
]:
    base = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts") / name
    files = list(base.glob("*.jsonl")) if base.exists() else []
    print(name, "files", len(files))
    for f in files:
        # find first $outer assignment content length
        with f.open(encoding="utf-8", errors="ignore") as fh:
            for i, line in enumerate(fh, 1):
                if "$outer" in line.replace("\\$", "$") or "\\$outer" in line:
                    text = line.replace("\\n", "\n").replace("\\'", "'").replace("\\$", "$")
                    m = re.search(r"\$outer\s*=\s*'([^']+)'", text)
                    if m:
                        print(f"  {f.name}:{i} outer_len={len(m.group(1))} start={m.group(1)[:70]}")
                        break
