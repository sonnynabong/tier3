---
name: astro-optimization
description: Build and delivery optimization for the static Astro Growtox homepage on Vercel. Use when configuring astro.config, vercel.json cache headers, assets, minify, or deploy output.
---

# Astro optimization (Tier3 homepage)

## Build

- `output: 'static'`. No Vercel adapter unless SSR is explicitly requested.
- Keep Astro’s default HTML/CSS/JS minify.
- `astro check` and `astro build` must pass before calling a goal done.

## Assets

- Put shipping rasters in `src/assets/` so `astro:assets` can hash, convert, and emit srcset.
- Prefer `<Picture>` with AVIF + WebP for photos; SVG stays SVG (logos, icons, process drawings).
- Keep provenance `*.webp.json` next to shipping rasters. Do not import originals from `wordpress/reference/assets/originals/`.
- Self-host Montserrat; subset is already latin `woff2`.

## Caching (Vercel)

In `astro/vercel.json`:

- Long-cache immutable `Cache-Control` for `/_astro/:path*` (content-hashed).
- Shorter cache for HTML documents.
- Do not cache-bust by query string on static files.

## Do not

- Add render-blocking analytics, tag managers, or webfont CDNs.
- Bundle a JS framework for this marketing page.
- Use npm workspaces at the repo root (Vercel installs from `/astro`).
- Commit `dist/`, `node_modules/`, or `.vercel/`.
