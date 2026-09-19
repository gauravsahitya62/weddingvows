# WVN Cinematic Sections (Elementor paste)

Self-contained HTML/CSS/vanilla JS blocks for weddingvowsbynikhil.com. No React, no build, no theme file edits.

## Files

| File | Section |
|------|---------|
| `00-fonts.html` | Google Fonts link (paste **once**) |
| `01-story.html` | Pinned mosaic film reveal — “The Story We Create” |
| `02-vows-standard.html` | Pinned VOWS text-mask zoom — “The Vows Standard” |
| `03-testimonials.html` | Editorial quote carousel |

## How to use in Elementor

1. Paste `00-fonts.html` once: **Site Settings → Custom Code → Head**, or the first HTML widget on the page.
2. Add three **HTML** widgets (or three Custom HTML blocks) in order.
3. Paste the full contents of `01`, `02`, and `03` into each widget.
4. Point the Section 2 CTA (`href="#contact"`) at your real contact section id if different.

## Notes

- All classes/ids are prefixed `wvn-`.
- Scroll motion uses sticky wrappers + rAF progress (transform/opacity only).
- `prefers-reduced-motion: reduce` shows static end states / skips autoplay carousel.
- Hotlinked media from your public WordPress uploads.
- Tested layouts: desktop ~1920, mobile ~390 (tile grid 2×3; VOWS at 34vw).
