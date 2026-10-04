---
name: wordpress-docker
description: Runs the local WordPress 7.1.2 demo with Docker Desktop. Use when starting or resetting the stack, activating the Tier3 theme, running WP-CLI, reseeding content, or debugging compose/bind-mount issues on Windows.
---

# WordPress Docker Desktop

Operator detail lives in [wordpress/README.md](../../../wordpress/README.md). Command cheat sheet: [reference.md](reference.md).

## Pins

Do not use floating `latest` tags.

- Site: `wordpress:7.1.2-php8.3-apache`
- CLI: `wordpress:cli-2.12.0-php8.3`
- Database: `mariadb:11`

Compose file: `wordpress/compose.yaml`. Theme bind mount: `wordpress/themes/tier3` → `wp-content/themes/tier3`.

## First run / everyday

Docker Desktop must be running.

```powershell
cd wordpress
.\docker\setup.ps1
```

That copies `.env` from `.env.example` if missing, starts db + wordpress, installs core when the volume is empty, asserts `wp core version` is `7.1.2`, and activates `tier3` (which seeds media, menus, and Home).

- Site: http://localhost:8080
- Admin: http://localhost:8080/wp-admin (`admin` / `tier3-demo`)

## Reseed and reset

```powershell
.\docker\setup.ps1 -ForceReseed
docker compose down -v
.\docker\setup.ps1
```

## Windows

If `tier3` is missing or the homepage looks like a default theme, confirm Docker Desktop file sharing includes `k:\git\tier3` and that `wp theme list` shows `tier3` as active. WP-CLI runs as `33:33` (www-data) against the same `wp_data` volume.
