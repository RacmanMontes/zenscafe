---
paths:
  - config/fortify.php
---

# Config

## Public registration disabled
Fortify registration feature is disabled. Users are created only by admins via the routed User Management interface (app/Livewire/Users/Create + app/Actions/User/CreateUser). The register URL returns 404 and the login view shows an admin-contact note. Do not re-enable Features::registration() without an admin-invite mechanism. The login view must not reference route('register') since that route no longer exists.
