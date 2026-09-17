# Wedding Vows by Nikhil — Redesign Spec

## Purpose
Server-rendered WordPress theme redesign for a Udaipur destination wedding studio. The experience is cinematic and editorial while preserving the existing blush/crimson brand system, logo assets, page URLs, SEO content, and WordPress-native editing workflow.

## Key flows
- Visitors land on the homepage, move through the hero, collective, planner story, services, proof, gallery, FAQ, and consultation CTA.
- Visitors can open wedding stories, portfolio images, the showreel, FAQ answers, the quick-search modal, and WhatsApp contact without leaving the server-rendered page model.
- Visitors can use the persistent primary navigation to reach Services, Blog, Weddings, and Contact while keeping all existing URLs.
- Editors update homepage copy, images, repeaters, weddings, services, testimonials, galleries, and footer links from WordPress admin/ACF. No SPA or client-side route replacement is used.

## Data and compatibility
- Existing `wvn_home_text()`, `wvn_home_image()`, `wvn_home_rows()`, portfolio CPT, and service/page helpers remain the content boundary.
- Existing ACF field names and routes are preserved. The redesign adds only optional homepage hero eyebrow and hero metadata fields with safe fallbacks.
- `wvn_elementor_editing()` behavior remains intact for pages where editors explicitly use Elementor.

## Visual system
- Primary blush `#b67a7a`, rose `#b52d50`, deep crimson `#8b001a`, gold `#ffd700`, warm paper `#f7f3ec`, ink `#2d2020`.
- Playfair/le-jour serif display type, Aboreto kicker type, and Open Sans/Jost body type.
- Motion uses CSS transitions plus the existing progressive-enhancement `bts.js` behaviors; `wvn-redesign.js` adds scroll progress, reveals, header state, and pointer depth. Reduced motion disables visual movement.

## Auth and integrations
No custom authentication or third-party API integration was added. Existing WordPress admin authentication and any currently installed plugins remain the source of truth.