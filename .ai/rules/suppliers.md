---
paths:
  - 'app/Livewire/Products/**,app/Livewire/Categories/**,app/Livewire/Suppliers/**'
---

# Suppliers

## Product/Category/Supplier create forms are modal-embedded, not pages
The "Add X" flows for products, categories, and suppliers open a flux:modal on the index page; the /products/create, /categories/create, /suppliers/create routes DO NOT exist. Each Create component is a nested Livewire child rendered only while the parent Index's showCreateModal is true (resets on every open via remount). On save it dispatches 'zenscafe-toast' (window) and then an XCreated event targeted to its parent Index (->to(Index::class)); the Index listens and closes the modal. The cancel button dispatches cancelXCreate to the parent. Keep these event names unique.
