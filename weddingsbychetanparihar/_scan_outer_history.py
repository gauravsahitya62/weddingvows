# -*- coding: utf-8 -*-
import re
from pathlib import Path

path = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts"
    r"\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)

# Find unique outer path prefixes from Write/StrReplace payloads
pat = re.compile(r"\$outer\s*=\s*'([^']{30,80})")
seen = {}
with path.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if "$outer" not in line and "\\$outer" not in line:
            continue
        # unescape common json escapes lightly
        text = line.replace("\\n", "\n").replace("\\'", "'").replace('\\"', '"')
        for m in pat.finditer(text):
            start = m.group(1)[:55]
            if start not in seen:
                seen[start] = i
                print(f"L{i}: {start}...")

print("--- color hits near wbc-art ---")
color_pat = re.compile(r"\.wbc-art-copy h1\{[^}]*color:\s*([^;]+)", re.S)
color_pat2 = re.compile(r"wbc-art-copy h1[^\n]{0,80}color:\s*#?[0-9a-fA-F]{3,8}")
with path.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if "735539" in line or "c9a227" in line or "b08d57" in line or "a67d47" in line or "8b6914" in line:
            if "wbc-art" in line or "site.css" in line or "fix_gold" in line:
                # print short context
                for c in ("735539", "c9a227", "b08d57", "a67d47", "8b6914", "D4AF37", "c4a574"):
                    if c.lower() in line.lower():
                        print(f"L{i}: color {c}")
                break
