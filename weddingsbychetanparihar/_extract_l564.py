# -*- coding: utf-8 -*-
from pathlib import Path
import json

p = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts"
    r"\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)
out = Path(r"d:\nikhil\weddingsbychetanparihar\_early_art_extract")
out.mkdir(exist_ok=True)

# Line 564 has multiple tool_use in one message - save each by path
with p.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if i != 564:
            continue
        obj = json.loads(line)
        n = 0
        for block in obj["message"]["content"]:
            if block.get("type") != "tool_use":
                continue
            inp = block.get("input") or {}
            path = inp.get("path", "")
            ns = inp.get("new_string") or inp.get("contents") or ""
            if not ns:
                continue
            n += 1
            safe = Path(path).name.replace(".", "_")
            fp = out / f"L564_{n}_{safe}.txt"
            fp.write_text(ns, encoding="utf-8")
            print(n, path, len(ns), "starts", ns[:80].replace("\n", " "))

# Also get CSS art from the site.css new_string that contains .wbc-art
for fpath in out.glob("L564_*site_css*"):
    print("css file", fpath, fpath.stat().st_size)
