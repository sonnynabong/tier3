# WordPress demo on Docker Desktop

Local Growtox homepage running as a WordPress 7.1.2 block theme. The shipping site is still the Astro app. This stack is for the block-theme demo only.

## What you get

- WordPress **7.1.2** (`wordpress:7.1.2-php8.3-apache`)
- WP-CLI **2.12.0** (`wordpress:cli-2.12.0-php8.3`)
- MariaDB 11
- Theme bind-mounted from [`themes/tier3`](themes/tier3)
- On first theme activation: media library, four navigation menus, header/footer, and a Home page already filled with the seven section blocks

## Start

Docker Desktop must be running.

```powershell
cd k:\git\tier3\wordpress
.\docker\setup.ps1
```

The script copies `.env` from `.env.example` if needed, starts the containers, installs WordPress when the volume is empty, checks `wp core version` is `7.1.2`, and activates the Tier3 theme (which runs the seed).

- Site: http://localhost:8080
- Admin: http://localhost:8080/wp-admin
- User / password: `admin` / `tier3-demo`

## Where the prefilled content lives

| Item | Location in wp-admin |
| --- | --- |
| Images | Media |
| Primary, Company, Resources, Product menus | Appearance → Editor → Navigation |
| Header and footer | Appearance → Editor → Patterns → Template parts |
| Homepage sections | Pages → Home (seven Tier3 blocks) |

## Daily commands

From `wordpress/`:

```powershell
docker compose up -d
docker compose down
docker compose logs -f wordpress
```

WP-CLI (one-shot container):

```powershell
docker compose --profile cli run --rm wpcli core version
docker compose --profile cli run --rm wpcli theme list
docker compose --profile cli run --rm wpcli post list --post_type=wp_navigation
```

Rewrite seeded content after editing the seed (keeps attachment IDs; refreshes managed posts):

```powershell
.\docker\setup.ps1 -ForceReseed
```

Or:

```powershell
docker compose --profile cli run --rm wpcli eval "tier3_seed(true);" --user=admin
```

## Reset the database and uploads

This deletes the WordPress and MariaDB volumes. Run it when you want a clean install.

```powershell
docker compose down -v
.\docker\setup.ps1
```

## Windows bind mounts

The theme path `./themes/tier3` is mounted over `wp-content/themes/tier3`. Edits on disk show up immediately; PHP changes may need a refresh. If the homepage looks like the default Twenty theme, confirm Docker Desktop file sharing includes `k:\git\tier3` and that `wp theme list` shows `tier3` as active.
