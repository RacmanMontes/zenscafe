---
paths:
  - .htaccess
  - public/**
---

# Public

## Deployed doc root is public_html; host serves the repo's public/ via a root .htaccess
zenscafe.pudoceast.com (Hostinger shared) git-deploys the repo (branch `main`) via hPanel into `domains/zenscafe.pudoceast.com/public_html` — the app files ARE the doc root, and the domain serves the real Laravel public dir through a thin `.htaccess` at the repo root. That wrapper:
- routes HTML to `public/index.php` (stock Laravel front controller, no `usePublicPath` hack)
- maps static assets to `/public/...` (e.g. `/build/assets/*`, `/logo/logo.png`, `/favicon.*`)
- returns 403 for everything sensitive that ships in the repo: `.env`, `.git`, `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `tests/`, `vendor/`, `artisan`, `composer.json`, `AGENTS.md`, …

If the wrapper `.htaccess` and `public/build` (vite manifest) are missing, every URL 404s/`/` 403s — each Hostinger git deploy wipes anything not in the repo, so keep the root `index.php`/wrapper and built assets committed, and re-run `php artisan migrate --force` after each deploy (`main` adds new migrations, e.g. `notifications`).