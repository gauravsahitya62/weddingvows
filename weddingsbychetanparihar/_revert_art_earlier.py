# -*- coding: utf-8 -*-
"""Revert Our Services / Art section to the earlier (pre brain-rebuild / bronze) look."""
from __future__ import annotations

import re
from pathlib import Path

THEME = Path(r"d:\nikhil\weddingsbychetanparihar\wp-content\themes\weddingsbychetanparihar")
FP = THEME / "front-page.php"
CSS = THEME / "assets" / "css" / "site.css"
MASK = THEME / "assets" / "brand" / "brain-mask.svg"
FN = THEME / "functions.php"

OUTER = (
    "M 16.0,444.0 L 16.0,228.0 Q 17.4,196.1 45.8,181.3 Q 47.5,150.4 75.6,137.5 "
    "Q 77.7,107.8 105.5,97.1 Q 108.0,68.9 135.3,61.0 Q 138.9,34.9 165.1,31.6 "
    "Q 180.0,15.6 194.9,31.6 Q 221.1,34.9 224.7,61.0 Q 252.0,68.9 254.5,97.1 "
    "Q 282.3,107.8 284.4,137.5 Q 312.5,150.4 314.2,181.3 Q 342.6,196.1 344.0,228.0 "
    "L 344.0,444.0 Z"
)
INNER = (
    "M 30.0,430.0 L 30.0,225.9 Q 34.3,198.5 57.3,182.9 Q 61.8,156.5 84.5,142.5 "
    "Q 89.3,117.4 111.8,105.2 Q 117.0,81.6 139.1,72.0 Q 145.0,50.6 166.4,44.8 "
    "Q 180.0,33.8 193.6,44.8 Q 215.0,50.6 220.9,72.0 Q 243.0,81.6 248.2,105.2 "
    "Q 270.7,117.4 275.5,142.5 Q 298.2,156.5 302.7,182.9 Q 325.7,198.5 330.0,225.9 "
    "L 330.0,430.0 Z"
)
CLIP_USER = (
    "M 24.0,436.0 L 24.0,226.8 Q 27.2,197.5 52.4,182.2 Q 55.8,154.0 80.7,140.3 "
    "Q 84.4,113.3 109.1,101.7 Q 113.2,76.3 137.5,67.3 Q 142.5,44.0 165.8,39.1 "
    "Q 180.0,26.1 194.2,39.1 Q 217.5,44.0 222.5,67.3 Q 246.8,76.3 250.9,101.7 "
    "Q 275.6,113.3 279.3,140.3 Q 304.2,154.0 307.6,182.2 Q 332.8,197.5 336.0,226.8 "
    "L 336.0,436.0 Z"
)
CLIP_OBB = (
    "M 0.0667,0.9478 L 0.0667,0.4930 Q 0.0756,0.4293 0.1456,0.3961 "
    "Q 0.1550,0.3348 0.2242,0.3050 Q 0.2344,0.2463 0.3031,0.2211 "
    "Q 0.3144,0.1659 0.3819,0.1463 Q 0.3958,0.0957 0.4606,0.0850 "
    "Q 0.5000,0.0567 0.5394,0.0850 Q 0.6042,0.0957 0.6181,0.1463 "
    "Q 0.6856,0.1659 0.6969,0.2211 Q 0.7656,0.2463 0.7758,0.3050 "
    "Q 0.8450,0.3348 0.8544,0.3961 Q 0.9244,0.4293 0.9333,0.4930 "
    "L 0.9333,0.9478 Z"
)

ART_BLOCK = f"""    <?php
    $intro = wbc_intro_defaults();
    $intro_icons = wbc_intro_icons();
    $intro_image = wbc_intro_image();
    $intro_alt = wbc_intro_value('alt', 'wbc_intro_image_alt');
    $outer = '{OUTER}';
    $inner = '{INNER}';
    ?>
    <section id="intro" class="wbc-art" aria-label="<?php echo esc_attr(wbc_intro_value('title', 'wbc_intro_title')); ?>">
        <div class="wbc-art-inner">
            <div class="wbc-art-copy">
                <p class="wbc-kicker"><?php echo esc_html(wbc_intro_value('kicker', 'wbc_intro_kicker')); ?></p>
                <h1><?php echo esc_html(wbc_intro_value('title', 'wbc_intro_title')); ?></h1>
                <p><?php echo esc_html(wbc_intro_value('text', 'wbc_intro_text')); ?></p>
                <a class="wbc-art-cta" href="<?php echo esc_url(wbc_intro_cta_url()); ?>">
                    <span><?php echo esc_html(wbc_mod('wbc_intro_cta', $intro['cta'])); ?></span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
            <div class="wbc-art-frame">
                <svg class="wbc-art-defs" width="0" height="0" aria-hidden="true" focusable="false">
                    <defs>
                        <clipPath id="wbc-art-clip" clipPathUnits="objectBoundingBox">
                            <path d="{CLIP_OBB}"/>
                        </clipPath>
                    </defs>
                </svg>
                <figure class="wbc-art-photo">
                    <img src="<?php echo esc_url($intro_image); ?>" alt="<?php echo esc_attr($intro_alt); ?>" width="720" height="920" loading="eager" decoding="async">
                </figure>
                <svg class="wbc-art-arch" viewBox="0 0 360 460" preserveAspectRatio="xMidYMax meet" aria-hidden="true" focusable="false">
                    <path class="wbc-art-stroke is-outer" d="<?php echo esc_attr($outer); ?>"/>
                    <path class="wbc-art-stroke is-inner" d="<?php echo esc_attr($inner); ?>"/>
                </svg>
            </div>
            <?php if ($intro_icons) : ?>
            <ul class="wbc-art-icons">
                <?php foreach ($intro_icons as $item) : ?>
                    <li>
                        <?php if (!empty($item['url'])) : ?><a href="<?php echo esc_url($item['url']); ?>"><?php endif; ?>
                            <?php if (!empty($item['icon'])) : ?>
                                <img src="<?php echo esc_url($item['icon']); ?>" alt="" width="40" height="40">
                            <?php endif; ?>
                            <?php if (!empty($item['label'])) : ?>
                                <span><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        <?php if (!empty($item['url'])) : ?></a><?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
    </section>
"""

CSS_ART = """\
.wbc-art {
  background: #eee4d0;
  padding: clamp(56px, 8vw, 96px) 0 clamp(40px, 6vw, 64px);
}
.wbc-art-inner {
  width: min(1120px, calc(100% - 48px));
  margin: 0 auto;
  display: grid;
  grid-template-columns: minmax(0, 1.05fr) minmax(280px, 0.95fr);
  grid-template-areas:
    "copy frame"
    "icons icons";
  gap: clamp(28px, 5vw, 64px) clamp(32px, 6vw, 80px);
  align-items: center;
}
.wbc-art-copy { grid-area: copy; max-width: 520px; }
.wbc-art-copy .wbc-kicker {
  margin-bottom: 18px;
  color: #8a6d3d;
}
.wbc-art-copy h1 {
  margin: 0 0 22px;
  color: #3a2a1c;
  font-size: clamp(34px, 4.6vw, 58px);
  font-style: normal;
  font-weight: 500;
  letter-spacing: 0.04em;
  line-height: 1.05;
  text-transform: uppercase;
}
.wbc-art-copy p {
  margin: 0 0 32px;
  max-width: 440px;
  color: #6a5a48;
  font-size: 16px;
  line-height: 1.7;
}
.wbc-art-cta {
  display: inline-flex;
  align-items: center;
  gap: 14px;
  min-height: 48px;
  padding: 12px 22px;
  border: 1px solid #8a6d3d;
  color: #3a2a1c;
  font-size: 11px;
  font-weight: 500;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  transition: background 0.35s ease, color 0.35s ease, border-color 0.35s ease;
}
.wbc-art-cta svg { width: 18px; height: 18px; }
.wbc-art-cta:hover {
  background: #3a2a1c;
  border-color: #3a2a1c;
  color: #eee4d0;
}
.wbc-art-frame {
  grid-area: frame;
  position: relative;
  justify-self: center;
  width: min(100%, 400px);
}
.wbc-art-defs {
  position: absolute;
  width: 0;
  height: 0;
}
.wbc-art-photo {
  margin: 0;
  aspect-ratio: 360 / 460;
  clip-path: url(#wbc-art-clip);
  -webkit-clip-path: url(#wbc-art-clip);
  -webkit-mask-image: url("../brand/brain-mask.svg");
  mask-image: url("../brand/brain-mask.svg");
  -webkit-mask-size: 100% 100%;
  mask-size: 100% 100%;
  -webkit-mask-repeat: no-repeat;
  mask-repeat: no-repeat;
  -webkit-mask-position: center;
  mask-position: center;
}
.wbc-art-photo img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.wbc-art-arch {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  overflow: visible;
  pointer-events: none;
}
.wbc-art-stroke {
  fill: none;
  stroke: #c4a574;
}
.wbc-art-stroke.is-outer { stroke-width: 2.4; }
.wbc-art-stroke.is-inner { stroke-width: 1.1; }
.wbc-art-icons {
  grid-area: icons;
  list-style: none;
  margin: 8px 0 0;
  padding: 18px 0 0;
  display: grid;
  grid-template-columns: repeat(6, minmax(0, 1fr));
  gap: 12px 20px;
  border-top: 1px solid rgba(138, 109, 61, 0.18);
}
.wbc-art-icons li,
.wbc-art-icons a {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  text-align: center;
  color: #6b5438;
}
.wbc-art-icons img {
  width: 40px;
  height: 40px;
  object-fit: contain;
}
.wbc-art-icons span {
  font-size: 10px;
  font-weight: 500;
  letter-spacing: 0.18em;
  text-transform: uppercase;
}
.wbc-art-icons a:hover { color: #3a2a1c; }
"""


def main() -> None:
    fp = FP.read_text(encoding="utf-8")
    nl = "\r\n" if "\r\n" in fp else "\n"
    art = ART_BLOCK.replace("\n", nl).rstrip() + nl + nl

    pat = re.compile(
        r"    <\?php\r?\n    \$intro = wbc_intro_defaults\(\);.*?    </section>\r?\n\r?\n    <section class=\"wbc-section wbc-latest\">",
        re.S,
    )
    fp2, n = pat.subn(art + '    <section class="wbc-section wbc-latest">', fp, count=1)
    if n != 1:
        raise SystemExit(f"front-page art block replace failed: {n}")
    FP.write_text(fp2, encoding="utf-8", newline="")
    print("front-page.php restored")

    css = CSS.read_text(encoding="utf-8")
    css_nl = "\r\n" if "\r\n" in css else "\n"
    css_art = CSS_ART.replace("\n", css_nl)
    css_pat = re.compile(
        r"\.wbc-art \{.*?\r?\n\.wbc-art-icons a:hover \{ color: #[0-9a-fA-F]+; \}\r?\n",
        re.S,
    )
    css2, n2 = css_pat.subn(css_art + css_nl, css, count=1)
    if n2 != 1:
        raise SystemExit(f"css art block replace failed: {n2}")
    css2 = css2.replace(
        ".wbc-art-frame { width: min(100%, 300px); }",
        ".wbc-art-frame { width: min(100%, 320px); }",
    )
    CSS.write_text(css2, encoding="utf-8", newline="")
    print("site.css restored")

    MASK.write_text(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 460" preserveAspectRatio="xMidYMid meet">\n'
        f'  <path fill="#fff" d="{CLIP_USER}"/>\n'
        "</svg>\n",
        encoding="utf-8",
        newline="\n",
    )
    print("brain-mask.svg restored")

    fn = FN.read_text(encoding="utf-8")
    fn2, nv = re.subn(
        r"define\(\s*'WBC_THEME_VERSION',\s*'[^']+'\s*\);",
        "define('WBC_THEME_VERSION', '3.0.6');",
        fn,
        count=1,
    )
    FN.write_text(fn2, encoding="utf-8", newline="")
    print("version bump", nv)

    t = FP.read_text(encoding="utf-8")
    assert "M 16.0,444.0" in t
    assert "360 460" in t
    assert "M78.01" not in t
    c = CSS.read_text(encoding="utf-8")
    assert "#3a2a1c" in c
    assert "#c4a574" in c
    assert "#735539" not in c
    print("ok")


if __name__ == "__main__":
    main()
