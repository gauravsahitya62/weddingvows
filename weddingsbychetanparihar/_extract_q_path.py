from pathlib import Path

p = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar"
    r"\agent-transcripts\f4466360-b215-4174-9d88-0da5d153d911"
    r"\f4466360-b215-4174-9d88-0da5d153d911.jsonl"
)
out = Path(r"d:\nikhil\weddingsbychetanparihar\_q_path_snip.txt")
needle = "M 24.0,436.0"
with p.open("r", encoding="utf-8", errors="replace") as f:
    for i, line in enumerate(f):
        if i != 759:
            continue
        idx = line.find(needle)
        print("line", i, "idx", idx)
        if idx < 0:
            print("not found")
            break
        chunk = line[idx : idx + 8000]
        z = chunk.find("Z")
        path = chunk[: z + 1] if z >= 0 else chunk[:2000]
        # clean escaped quotes in JSON
        path = path.replace("\\'", "'").replace('\\"', '"')
        # stop at first quote after Z if present
        if "'" in path:
            path = path.split("'")[0]
            if not path.endswith("Z"):
                path = path  # already cut
        out.write_text(path, encoding="utf-8")
        print("saved", out, "len", len(path))
        print(path[:500])
        print("...")
        print(path[-200:])
        break
