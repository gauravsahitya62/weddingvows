import re
from pathlib import Path

p = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl")

for i, line in enumerate(p.open(encoding="utf-8", errors="ignore"), 1):
    if i not in (564, 566, 569, 659, 760):
        continue
    # Find absolute paths: M with integer coords before decimal (not 0.)
    for m in re.finditer(r'M\s*([1-9]\d*(?:\.\d+)?),\s*([\d.]+)(?:[^"\'\\]|\\.){20,8000}?Z', line):
        path = m.group(0)
        path = path.replace('\\"', '"').replace("\\'", "'")
        # stop at first Z
        if "Z" in path:
            path = path[: path.index("Z") + 1]
        q = len(re.findall(r"\bQ\b", path))
        l = len(re.findall(r"\bL\b", path))
        print(f"L{i} Q={q} L={l} len={len(path)}")
        print(path[:200])
        print("...")
        print(path[-200:])
        print("---")
        out = Path(f"_path_L{i}_Q{q}.txt")
        out.write_text(path, encoding="utf-8")
        print("wrote", out)
