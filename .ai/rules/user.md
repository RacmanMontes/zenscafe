---
paths:
  - 'app/Actions/User/**'
---

# User

## Role changes require admin acting user in actions
User role is NOT in the User model's fillable list. CreateUser and UpdateUser actions explicitly assign role via `$user->role = UserRole::from(...)` ONLY when the acting user (`$request?->user() ?? auth()->user()`) is an admin; otherwise role is forced to staff. Role changes must never go through mass assignment.
