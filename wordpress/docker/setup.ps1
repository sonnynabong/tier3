param(
	[switch]$ForceReseed
)

$ErrorActionPreference = "Stop"

$wordpressRoot = Split-Path -Parent $PSScriptRoot
Set-Location $wordpressRoot

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
	throw "Docker is not on PATH. Start Docker Desktop and retry."
}

docker info | Out-Null
if ($LASTEXITCODE -ne 0) {
	throw "Docker Desktop is not running."
}

if (-not (Test-Path -Path (Join-Path $wordpressRoot ".env"))) {
	Copy-Item (Join-Path $wordpressRoot ".env.example") (Join-Path $wordpressRoot ".env")
}

Get-Content (Join-Path $wordpressRoot ".env") | ForEach-Object {
	if ($_ -match '^\s*#' -or $_ -notmatch '=') { return }
	$name, $value = $_ -split '=', 2
	Set-Item -Path "Env:$name" -Value $value.Trim()
}

function Invoke-WpCli {
	param([Parameter(Mandatory = $true)][string[]]$WpArgs)
	docker compose --profile cli run --rm wpcli @WpArgs
	if ($LASTEXITCODE -ne 0) {
		throw "WP-CLI failed: wp $($WpArgs -join ' ')"
	}
}

Write-Host "Starting MariaDB and WordPress 7.1.2..."
docker compose up -d db wordpress
if ($LASTEXITCODE -ne 0) {
	throw "docker compose up failed."
}

$ready = $false
for ($i = 0; $i -lt 60; $i++) {
	docker compose exec -T wordpress test -f /var/www/html/wp-includes/version.php 2>$null
	if ($LASTEXITCODE -eq 0) {
		$ready = $true
		break
	}
	Start-Sleep -Seconds 2
}
if (-not $ready) {
	throw "WordPress core files did not appear in the volume."
}

$installed = $true
docker compose --profile cli run --rm wpcli core is-installed
if ($LASTEXITCODE -ne 0) {
	$installed = $false
}

if (-not $installed) {
	Write-Host "Installing WordPress at $($env:WORDPRESS_URL)..."
	Invoke-WpCli @(
		"core", "install",
		"--url=$($env:WORDPRESS_URL)",
		"--title=$($env:WORDPRESS_TITLE)",
		"--admin_user=$($env:WORDPRESS_ADMIN_USER)",
		"--admin_password=$($env:WORDPRESS_ADMIN_PASSWORD)",
		"--admin_email=$($env:WORDPRESS_ADMIN_EMAIL)",
		"--skip-email"
	)
}

$version = (docker compose --profile cli run --rm wpcli core version).Trim()
if ($version -ne "7.1.2") {
	throw "Expected WordPress 7.1.2, found '$version'."
}

Invoke-WpCli @("rewrite", "structure", "/%postname%/", "--hard")
Invoke-WpCli @("theme", "activate", "tier3", "--user=$($env:WORDPRESS_ADMIN_USER)")

if ($ForceReseed) {
	Write-Host "Rewriting seeded demo content..."
	Invoke-WpCli @("eval", "tier3_seed(true);", "--user=$($env:WORDPRESS_ADMIN_USER)")
}

Write-Host ""
Write-Host "WordPress $version is ready."
Write-Host "Site:  $($env:WORDPRESS_URL)"
Write-Host "Admin: $($env:WORDPRESS_URL)/wp-admin  ($($env:WORDPRESS_ADMIN_USER) / $($env:WORDPRESS_ADMIN_PASSWORD))"
