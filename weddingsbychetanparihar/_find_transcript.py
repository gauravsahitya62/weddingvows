from pathlib import Path
import os

needles = [
    "M 80.0,72.0 L 86.0,64.0",
    "L 86.0,64.0 L 93.0,57.0",
    "Parsed 92",
    "92-point",
    "92 pts",
]

roots = [
    Path(r"C:\Users\Asus\.cursor\projects"),
    Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"),
]

print("=== finding f4466360 transcripts ===")
for root in roots:
    if not root.exists():
        continue
    for p in root.rglob("*f4466360*"):
        print(p)

print("\n=== scanning agent-transcripts for L needle ===")
for root in roots:
    at = root / "agent-transcripts"
    if not at.exists():
        continue
    for p in at.rglob("*.jsonl"):
        try:
            text = p.read_text(encoding="utf-8", errors="ignore")
        except Exception as e:
            print("read fail", p, e)
            continue
        for n in needles:
            if n in text:
                print("HIT", n, "in", p)
                # show nearby context size
                idx = text.find(n)
                print("  idx", idx, "snippet:", repr(text[max(0, idx - 40) : idx + 80]))
                break
