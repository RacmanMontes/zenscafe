---
paths:
  - public/index.php
---

# Public

## Deployed doc root is public_html, not public_html/public
zenscafe.pudoceast.com (Hostinger) serves the repo flattened into domains/zenscafe.pudoceast.com/public_html — index.php, .htaccess, favicons and the vite build live at that root, not in a nested public/ dir. The deployed index.php therefore calls $app->usePublicPath(__DIR__) after loading bootstrap/app.php, otherwise public_path() resolves to public_html/public and Vite throws "manifest not found at .../public/build/manifest.json". Assets must be at public_html/build (upload local public/build) and public_html/logo/logo.png. If doc root ever changes to public_html/public, drop that usePublicPath call.
