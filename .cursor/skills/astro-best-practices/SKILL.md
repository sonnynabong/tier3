---
name: astro-best-practices
description: Astro conventions for the Tier3 Growtox homepage in /astro. Use when creating or editing Astro pages, layouts, or components; scaffolding the app; or choosing islands, scripts, and content sources.
---

# Astro best practices (Tier3 homepage)

## Project

- App lives in `/astro` as a self-contained npm package (own lockfile). Vercel Root Directory is `astro`.
- `output: 'static'`. No React, Vue, or other UI framework.
- Verified copy only. Do not invent testimonials, stats, services, or relationships.
- Visual parity with `wordpress/reference/`. Do not restyle against the Impeccable homepage brief (coral/violet, Montserrat, bottle-led hero, staggered second testimonial).

## Structure

```
astro/src/
  assets/          # rasters/SVGs for astro:assets (keep .webp.json provenance)
  data/            # typed verified content
  fonts/           # self-hosted Montserrat
  styles/global.css
  layouts/BaseLayout.astro
  components/      # one component per page part
  pages/index.astro
```

- Pages compose components. Layout owns `<html>`, `<head>`, skip link, icon sprite.
- Prefer `.astro` components. Props are typed in the frontmatter.
- CTAs link to live Tier3/Growtox URLs. No local form submission.

## Scripts

- Zero JS by default. Add a component `<script>` only for header navigation and editorial motion.
- Do not use `client:*` frameworks. Processed Astro scripts are enough.
- Honor `prefers-reduced-motion: reduce` (no spatial entrance/reveals).

## Content

- Keep HTML semantics from the reference page (`header`, `main`, `section`, `blockquote`, `address`).
- Do not “align” the two results quotes; the secondary quote stays lower than the lead.
