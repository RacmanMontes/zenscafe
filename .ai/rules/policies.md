---
paths:
  - 'app/Policies/**'
---

# Policies

## Policies exist; wire action classes not inline logic
ProductPolicy, CategoryPolicy, and SupplierPolicy define view/viewAny/create/update/delete abilities (all true for verified users). All archive operations (product, category, supplier) MUST be performed via the Archive* action classes (which write audit logs) and authorized via `$this->authorize('delete', $model)` in the Livewire component — never inline model delete/update. Retain the pattern when adding new mutations.
