# Chetan Parihar Weddings

A fully dynamic WordPress wedding studio — every public section is editable from wp-admin. Visual language follows the editorial Udaipur direction of the `nikhil` site (Aboreto, cream/wine, pill navigation, pinned hero, coverflow portfolio) and is tailored to Chetan Parihar’s destination-planning practice.

## What the admin can manage

| Screen | What it controls |
| --- | --- |
| **Appearance → Customize → Chetan Parihar Weddings** | Brand, NAP address, phone, email, founder bio/photo, homepage copy, stats, social/directory links, SEO/GEO profile, hero & editorial images |
| **Weddings** | Portfolio stories, venue, city, season, guests, style, film URL, gallery picker, planning notes, per-page SEO |
| **Services** | Service pages shown on `/services/` and the homepage grid |
| **Destinations** | GEO city pages (Udaipur, Jaipur, Jodhpur, Goa…) with season, venue types, lat/long |
| **Process Steps** | The four-step “how we work” narrative |
| **Press & Awards** | Publication features |
| **Testimonials** | Reviews + ratings (also feed Review schema) |
| **FAQs** | Answer-engine questions (FAQPage schema) |
| **Contact Leads** | Form submissions (name, email, phone, date, city, guests, budget) |
| **Journal / Posts** | Planning articles |
| **Pages** | About, Contact, Privacy, Home |

## SEO / AEO / GEO

- Dynamic titles, meta descriptions, canonicals, Open Graph, Twitter cards
- Per-entry SEO title + AEO description fields
- JSON-LD graph: LocalBusiness, Person, WebSite, WebPage, Service, FAQPage, Article, Event/CreativeWork, Place/TouristDestination, BreadcrumbList, AggregateRating
- NAP + `geo.region` / `geo.position` / ICBM
- Destination landing pages written as answerable city guides
- Visible `Updated Month Year` on key pages
- Dynamic `/sitemap.xml`, `/wbc-sitemap.xml`, `/llms.txt`, `/llms-full.txt`
- robots.txt allows search + retrieval bots (Google, Bing, GPT, Perplexity, Claude, Apple)

## Local setup

1. Copy `.env.example` to `.env`.
2. `docker compose up -d`
3. Open `http://localhost:8088` and complete the WordPress installer if prompted.
4. Activate **Chetan Parihar Weddings** under Appearance → Themes.

The theme seeds Home, About, Contact, Journal, Privacy, and starter weddings/services/destinations/FAQs on first load.

## After activation

1. **Appearance → Customize** — set logo, phone, email, WhatsApp, Instagram, founder photograph.
2. Replace Unsplash placeholders with real wedding photography (Featured Image on each Wedding / Destination).
3. Edit FAQs and journal posts so they match how the studio actually answers couples.
4. Point the live domain, then submit `https://yourdomain.com/sitemap.xml` in Search Console.

When you have reference URLs (live sites, moodboards, photography), drop them in and the theme copy/layout can be tuned to match.
