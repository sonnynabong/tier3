# WP-CLI and Compose commands

Run from `wordpress/`.

## Stack

```powershell
docker compose up -d
docker compose down
docker compose down -v
docker compose logs -f wordpress
```

## WP-CLI

The `wpcli` service uses Compose profile `cli` and entrypoint `wp`.

```powershell
docker compose --profile cli run --rm wpcli core version
docker compose --profile cli run --rm wpcli theme list
docker compose --profile cli run --rm wpcli theme activate tier3 --user=admin
docker compose --profile cli run --rm wpcli post list --post_type=page
docker compose --profile cli run --rm wpcli post list --post_type=wp_navigation
docker compose --profile cli run --rm wpcli post list --post_type=attachment
docker compose --profile cli run --rm wpcli eval "tier3_seed(true);" --user=admin
```

`setup.ps1` wraps install + activate. Pass `-ForceReseed` to rewrite managed posts after seed PHP changes.
