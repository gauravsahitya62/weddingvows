from pathlib import Path
import re

p = Path(r"d:\nikhil\weddingsbychetanparihar\_trace_ref_brain.py")
t = p.read_text(encoding="utf-8")
new_ref = (
    r'REF = Path(r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar'
    r"\assets\c__Users_Asus_AppData_Roaming_Cursor_User_workspaceStorage_"
    r'793ad060b5b1740f1392a74d85beebef_images_image-75cf0807-e90b-430c-a226-1cbab9c741f2.png")'
)
t2 = re.sub(r"^REF = Path\(r\".*?\"\)", new_ref, t, count=1, flags=re.M)
p.write_text(t2, encoding="utf-8")
print("updated", t != t2)
print([ln for ln in t2.splitlines() if ln.startswith("REF =")][0])
ref = Path(
    r"C:\Users\Asus\.cursor\projects\d-nikhil-weddingsbychetanparihar\assets"
    r"\c__Users_Asus_AppData_Roaming_Cursor_User_workspaceStorage_"
    r"793ad060b5b1740f1392a74d85beebef_images_image-75cf0807-e90b-430c-a226-1cbab9c741f2.png"
)
print("exists", ref.exists(), ref.stat().st_size if ref.exists() else 0)
