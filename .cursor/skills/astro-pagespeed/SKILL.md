---
name: astro-pagespeed
description: Core Web Vitals and Lighthouse guidance for the Astro Growtox homepage. Use when touching LCP, fonts, images, CLS, JS budget, or prefers-reduced-motion.
---

# Astro PageSpeed (Tier3 homepage)

## LCP

- The Growtox bottle is the LCP element. Use `astro:assets` `<Picture>` with `formats={['avif', 'webp']}`.
- `fetchpriority="high"`, `loading="eager"`, explicit width/height. Do not lazy-load it.
- Preload the self-hosted Montserrat `woff2` (`as="font"`, `type="font/woff2"`, `crossorigin`).
- Do not load Google Fonts or other third-party stylesheets.

## Images

- Below-the-fold rasters: `loading="lazy"` and `decoding="async"`.
- Always pass width and height (or let `Image` infer from imports) to avoid CLS.
- Logos: constrain with CSS; keep `object-fit: contain`.
- Decorative process SVGs: empty `alt`.

## JavaScript

- Ship no JS until header/motion scripts are required. Keep those scripts small and deferred (Astro bundled `<script>`).
- Navigation must work without JS (menu expanded in the unenhanced document; enhance with `.navigation-ready`).

## Motion and CLS

- Honor `prefers-reduced-motion: reduce`: skip hero entrance and `[data-reveal]` animations.
- Do not animate layout properties that shift LCP (avoid animating bottle `width`/`height`).
- Sticky header: keep `html { scroll-padding-top }` from global CSS.

## Checks

After visual work: `npm run build` in `/astro`, then a desktop + ~390px pass. Confirm bottle is LCP, fonts do not block with a FOIT, and skip link still works.
