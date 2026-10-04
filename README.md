# Tier3 Media homepage

A premium editorial Growtox homepage for aesthetic practice owners. Verified copy and assets only.

## Delivery

The shipping site is the static Astro app in [`astro/`](astro/). Qualification and other business links go to live Tier3 services. No forms submit locally.

[`wordpress/reference/`](wordpress/reference/) is the HTML snapshot used for the original redesign. Keep it; do not treat it as the deploy target.

## Local development

```sh
cd astro
npm install
npm run dev
```

Then open http://localhost:4321. Production build: `npm run build` (output in `astro/dist/`).

## Vercel (GitHub)

Connect this GitHub repository in the Vercel dashboard:

1. Framework Preset: **Astro**
2. Root Directory: **`astro`**
3. Build Command: `npm run build` (default)
4. Output Directory: `dist` (default)

Pushing to a non-production branch creates a preview. Production deploys follow the production branch you choose in Vercel. Do not run `vercel link` unless you are configuring that dashboard connection.

## Workflow

One commit per goal. Agent guidance for this app lives in [`.cursor/skills/`](.cursor/skills/).
