---
name: wordpress-block-theme
description: Conventions for the Tier3 Growtox WordPress block theme in wordpress/themes/tier3. Use when editing section blocks, theme.json, template parts, PHP renders, editor.js, the activation seed, or homepage copy/images in the WordPress demo.
---

# Tier3 WordPress block theme

Shipping site is still Astro. This theme is the local WordPress demo of the same homepage.

## Source of truth

Copy, URLs, alt text, and layout come from `wordpress/reference/index.html` (plus `styles.css` / `script.js`). Do not invent testimonials, stats, logos, or relationships.

Keep the staggered second quote (`.testimonial-secondary` sits lower than the lead). Do not align the two results columns.

## Layout

```
wordpress/themes/tier3/
  theme.json                 # coral/violet/ink, Montserrat, zero block gap
  functions.php              # enqueue, SVG mime, after_switch_theme
  inc/helpers.php            # kses, icons, image fallbacks
  inc/blocks.php             # register seven section blocks
  inc/seed.php               # media, four menus, header/footer, Home page
  blocks/<name>/block.json + render.php
  assets/css/theme.css       # port of the reference CSS plus WP header/footer
  assets/js/theme.js         # hero + reveal motion only
  assets/js/editor.js        # InspectorControls + ServerSideRender
```

Header, footer, and navigation are core Site Editor blocks. Homepage sections are dynamic blocks that print the reference markup:

- `tier3/hero`
- `tier3/results`
- `tier3/case-study`
- `tier3/growth-band`
- `tier3/process`
- `tier3/practices`
- `tier3/closing`

Editor scripts stay plain `wp.element` JavaScript (no Node build).

## Seed

`after_switch_theme` runs `tier3_seed()`. It imports `assets/images/*` into the media library (`_tier3_source`), creates four `wp_navigation` posts (Primary, Footer Company, Footer Resources, Footer Product), writes customized header/footer parts, and publishes Home as the static front page with the seven blocks prefilled.

Idempotent: skip when `tier3_seed_version` matches. Force rewrite of managed posts:

```powershell
docker compose --profile cli run --rm wpcli eval "tier3_seed(true);" --user=admin
```

Run WP-CLI from `wordpress/` with Docker Desktop. See `wordpress-docker`.

## Links

Keep the live Tier3 / Growtox / Workable URLs from the reference file. Do not add stub inner pages.
