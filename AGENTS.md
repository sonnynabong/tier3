# Agent memory

Durable workspace facts and recurring user preferences for Tier3 Media / Growtox homepage work. See `PRODUCT.md` and `.impeccable/surface-briefs/homepage.md` for authoritative product and design contracts.

## Workspace

- Shipping site: static Astro app in `astro/` (no UI framework, no local form submission; CTAs link to live Tier3 services).
- Snapshot: `wordpress/reference/` remains the HTML/CSS/JS reference of the same homepage.
- WordPress demo: block theme in `wordpress/themes/tier3`, local stack in `wordpress/compose.yaml` (WordPress 7.1.2). Activate via `wordpress/docker/setup.ps1`; the theme seeds media, menus, and the front page.
- Git: foundation history on `main`; homepage work uses one commit per goal.
- Vercel: GitHub integration with Root Directory `astro` and Framework Preset Astro. Do not create a Vercel project from the CLI unless asked.
- Impeccable on Windows: `c:\Users\User\.cursor\skills\impeccable\scripts\impeccable.cmd` with project cwd at repo root. Live iteration is configured for `astro/src/pages/index.astro`.

## Content and scope

- Use verified copy, testimonials, statistics, logos, and assets from the tier3media.com source inventory only; do not invent claims or relationships.
- Homepage mode is Persuade (marketing landing); premium editorial direction (coral/violet, Montserrat, bottle-led hero) is pinned in the surface brief.

## Recurring preferences

- Landing-page mockups and visual-composition explorations go under `wordpress/reference/images/visualcomposition`, not ad hoc folders.
- Results/testimonials layout intentionally staggers the second quote (supporting story lower than the lead); do not “align” them into matching columns unless the user asks to change the editorial pairing.

## Impeccable finish bar

Per the homepage brief, a build is not finished without finish review, a recorded verdict, `DESIGN.md`, and provenance on shipping rasters.

## Learned User Preferences

- Keep WordPress homepage section bands (Results, case study, growth band, process, and closing) in the centered reference column, including when theme CSS would clear the auto margins.

## Learned Workspace Facts

- This repository is the Tier3 demo build of the Growtox homepage, separate from the live tier3media.com production site.
- The Astro homepage is section components: Header, Hero, Results, CaseStudy, GrowthBand, Process, Practices, Closing, and Footer.
- WordPress homepage sections are seven dynamic blocks (hero, results, case study, growth band, process, practices, closing). Seeded copy is block attributes, edited in the Block sidebar after selecting the section; the editor canvas is a server-rendered preview.
- The Astro favicon is the coral speech-bubble mark from tier3media.com, stored as PNGs in `astro/public/`.
