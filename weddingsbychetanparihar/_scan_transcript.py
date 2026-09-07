from pathlib import Path
import re

p = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911\f4466360-b215-4174-9d88-0da5d153d911.jsonl")
print("exists", p.exists(), "size", p.stat().st_size if p.exists() else 0)

needles = [
    "L 86.0,64.0 L 93.0,57.0",
    "M 80.0,72.0 L 86.0,64.0",
    "L 86.0,64.0",
    "points_to_q",
    "92-point",
    "92 points",
]
counts = {n: 0 for n in needles}
good = []
with p.open("r", encoding="utf-8", errors="ignore") as f:
    for i, line in enumerate(f, 1):
        for n in needles:
            if n in line:
                counts[n] += 1
                if n.startswith("L 86") or n.startswith("M 80"):
                    m = re.search(r"M 80\.0,72\.0(?: L [-0-9.]+,[-0-9.]+){30,}", line)
                    if m and counts[n] <= 2:
                        s = m.group(0)
                        print("HIT", n, "line", i, "Lcount", s.count(" L "), "snip", s[:160])
        # look for outer= with modest Q count
        if "$outer" in line and " Q " in line:
            for m in re.finditer(r"\$outer\s*=\s*'(M [^']{300,})'", line):
                d = m.group(1)
                qc = d.count(" Q ")
                lc = d.count(" L ")
                if (50 <= qc <= 120) or (80 <= lc <= 110):
                    good.append((i, qc, lc, d[:90]))

print("counts", counts)
print("good candidates", len(good))
for g in good[:8]:
    print(g)
