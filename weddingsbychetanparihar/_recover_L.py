import re
from pathlib import Path

p = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"
    r"\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911"
    r"\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)
out = Path(r"d:\nikhil\weddingsbychetanparihar\_l_source.txt")
needle = "M 80.0,72.0 L 86.0,64.0 L 93.0,57.0 L 101.0,51.0"
pat = re.compile(r"M 80\.0,72\.0(?: L [0-9.]+,[0-9.]+){40,250}")

found = 0
with p.open(encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        if needle not in line:
            continue
        m = pat.search(line)
        if not m:
            continue
        s = m.group(0)
        if " L 110.0,46.0" not in s:
            continue
        print("line", i, "len", len(s), "Lcount", s.count(" L "))
        print(s[:180], "...")
        print(s[-100:])
        out.write_text(s + " Z", encoding="utf-8")
        found = 1
        break

# Also try theme front-page from Cursor history / backup
if not found:
    # Search any agent transcripts under project
    root = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts")
    for jf in root.rglob("*.jsonl"):
        with jf.open(encoding="utf-8", errors="ignore") as f:
            for i, line in enumerate(f, 1):
                if "M 80.0,72.0 L 86.0,64.0 L 93.0,57.0" not in line:
                    continue
                m = pat.search(line)
                if m and m.group(0).count(" L ") >= 80:
                    s = m.group(0)
                    print("from", jf.name, "line", i, "Lcount", s.count(" L "))
                    out.write_text(s + " Z", encoding="utf-8")
                    found = 1
                    break
        if found:
            break

print("found", found)
