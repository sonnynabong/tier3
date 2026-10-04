# Tier3 Media homepage

This repository is the Tier3 demo build: a premium editorial Growtox homepage for aesthetic practice owners. It is a demonstration of the homepage, not the live Tier3 production site. Verified copy and assets only. Qualification and other business links go to live Tier3 services. Nothing in this repo submits a form locally.

## Layout

| Path | Role |
| --- | --- |
| [`astro/`](astro/) | Demo site. Static Astro app deployed on Vercel. |
| [`wordpress/themes/tier3`](wordpress/themes/tier3) | WordPress block theme of the same homepage, for a local demo. |
| [`wordpress/reference/`](wordpress/reference/) | HTML, CSS, and JS snapshot of the original redesign. Keep it; do not deploy it. |

## Astro

Requires Node.js 22.12 or newer.

```sh
cd astro
npm install
npm run dev
```

Open http://localhost:4321. `npm run build` writes the static site to `astro/dist/`. `npm run preview` serves that build.

The site is configured for `https://tier3media.com`, emits a sitemap, and serves `robots.txt`. Hashed files under `/_astro/` are cached immutably via [`astro/vercel.json`](astro/vercel.json).

### Vercel (GitHub)

Connect this repository in the Vercel dashboard:

1. Framework Preset: **Astro**
2. Root Directory: **`astro`**
3. Build Command: `npm run build` (default)
4. Output Directory: `dist` (default)

Pushing to a non-production branch creates a preview. Production deploys follow the production branch you choose in Vercel. Do not run `vercel link` unless you are configuring that dashboard connection.

## WordPress

Local demo only. Docker Desktop runs WordPress 7.1.2 (PHP 8.3), MariaDB 11, and WP-CLI. The theme is mounted from [`wordpress/themes/tier3`](wordpress/themes/tier3), so theme edits show up without rebuilding the image.

From `wordpress/`, with Docker Desktop running:

```powershell
.\docker\setup.ps1
```

The script copies [`.env.example`](wordpress/.env.example) to `.env` on first run, starts the stack, installs WordPress if needed, and activates the Tier3 theme. Activation imports the reference images, menus, and front-page blocks. Defaults (overridable in `.env`):

- Site: http://localhost:8080
- Admin: http://localhost:8080/wp-admin (`admin` / `tier3-demo`)

Rewrite the seeded homepage after theme changes with:

```powershell
.\docker\setup.ps1 -ForceReseed
```

Stop the stack from `wordpress/`:

```sh
docker compose down
```

Database and WordPress files stay in Docker volumes. `wordpress/.env` is gitignored.

## Workflow

One commit per goal. Agent guidance for this app lives in [`.cursor/skills/`](.cursor/skills/).
