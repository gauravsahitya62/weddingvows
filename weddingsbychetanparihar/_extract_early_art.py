# -*- coding: utf-8 -*-
"""Extract first art section new_string from transcript line 564."""
from pathlib import Path
import json
import re

p = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts"
    r"\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)

out = Path(r"d:\nikhil\weddingsbychetanparihar\_early_art_extract")
out.mkdir(exist_ok=True)

with p.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if i not in (564, 566, 569, 640, 658, 758):
            continue
        try:
            obj = json.loads(line)
        except Exception:
            continue
        msg = obj.get("message", {})
        content = msg.get("content", [])
        if not isinstance(content, list):
            continue
        for block in content:
            if not isinstance(block, dict):
                continue
            if block.get("type") != "tool_use":
                continue
            inp = block.get("input") or {}
            if "new_string" in inp:
                (out / f"L{i}_new.txt").write_text(inp["new_string"], encoding="utf-8")
                print(f"L{i} new_string len={len(inp['new_string'])} path={inp.get('path','')[-40:]}")
            if "contents" in inp and "brain" in str(inp.get("path", "")).lower():
                (out / f"L{i}_contents.txt").write_text(inp["contents"], encoding="utf-8")
                print(f"L{i} contents path={inp.get('path')}")
            if "old_string" in inp and i == 564:
                (out / f"L{i}_old.txt").write_text(inp["old_string"], encoding="utf-8")

# Also dump CSS art block from around first implementation - search for .wbc-art {
with p.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if ".wbc-art {" not in line and ".wbc-art{" not in line:
            continue
        text = line.replace("\\n", "\n")
        m = re.search(r"\.wbc-art \{.*?\}\n\.wbc-art-icons a:hover[^}]+\}", text, re.S)
        if m:
            (out / f"L{i}_css_art.txt").write_text(m.group(0), encoding="utf-8")
            print("css block at", i, "len", len(m.group(0)))
            break
        # try extracting new_string that contains .wbc-art {
        if '"new_string"' in line and ".wbc-art" in line:
            try:
                obj = json.loads(line)
            except Exception:
                continue
            for block in obj.get("message", {}).get("content", []):
                if isinstance(block, dict) and block.get("type") == "tool_use":
                    ns = (block.get("input") or {}).get("new_string", "")
                    if ".wbc-art {" in ns and len(ns) > 200:
                        (out / f"L{i}_css_new.txt").write_text(ns[:5000], encoding="utf-8")
                        print("css new at", i, "len", len(ns))
