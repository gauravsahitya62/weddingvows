from pathlib import Path

hist = Path(r"C:\Users\Asus\AppData\Roaming\Cursor\User\History")
hits = []
for f in hist.rglob("*"):
    if not f.is_file():
        continue
    if f.suffix.lower() not in {".php", ".svg", ".txt"}:
        continue
    try:
        t = f.read_text(encoding="utf-8", errors="ignore")
    except Exception:
        continue
    if "$outer" not in t and "clip0" not in t and "brain" not in t.lower():
        continue
    nL = t.count(" L ")
    nQ = t.count(" Q ")
    if nL >= 40 and nQ < 20:
        i = t.find("$outer")
        if i < 0:
            i = t.find('d="M ')
        sn = t[i : i + 100].replace("\n", " ")
        hits.append((nL, nQ, str(f), sn))

hits.sort(reverse=True)
print("L-heavy hits", len(hits))
for h in hits[:20]:
    print(h[0], h[1], h[2])
    print(" ", h[3][:120])
