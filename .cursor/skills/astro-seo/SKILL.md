---
name: astro-seo
description: SEO for the Astro Growtox homepage. Use when editing BaseLayout head tags, astro.config site URL, sitemap, robots.txt, Open Graph, Twitter cards, or JSON-LD.
---

# Astro SEO (Tier3 homepage)

## Config

- Set `site` in `astro.config.mjs` to the production origin (`https://tier3media.com` until cutover says otherwise).
- Add `@astrojs/sitemap`. Do not list unpublished routes.

## Document head

In `BaseLayout.astro`:

- Unique `<title>` and meta description (use the verified homepage strings).
- Canonical: `new URL(Astro.url.pathname, Astro.site)`.
- `lang="en"`, viewport, `theme-color` `#ff5151`.
- Favicon: coral logo SVG.
- Open Graph + Twitter: `og:type=website`, title, description, url, `og:image` from the bottle or a dedicated social raster. Absolute URLs only.
- Do not add keywords meta, fake review stars, or invented Organization extras.

## robots.txt

Dynamic `src/pages/robots.txt.ts` that allows `/` and points `Sitemap:` at `sitemap-index.xml` on `Astro.site`.

## JSON-LD

Emit one `<script type="application/ld+json">` in the layout from **existing footer facts only**:

- `@type`: `Organization` (and `LocalBusiness` if useful) — name Tier3 Media
- `email`: info@tier3media.com
- `telephone`: +1-732-808-4113
- `address`: 197 State Route 18 South, Ste 3000-4299, East Brunswick, NJ 08816

No aggregateRating, no extra locations, no unverified sameAs beyond the footer social links (Facebook, Instagram, Twitter).
