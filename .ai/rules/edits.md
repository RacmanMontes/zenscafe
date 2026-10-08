---
paths:
  - 'app/Livewire/Products/Edits/**,app/Livewire/Categories/**,app/Livewire/Suppliers/Edits/**'
---

# Edits

## Product/Category/Supplier edit forms are modal-embedded, not pages
Product/Category/Supplier EDIT forms are also modal-embedded on the index pages; the /products/{product}/edit, /categories/{category}/edit, /suppliers/{supplier}/edit routes DO NOT exist. The Index exposes openEditModal(id) and holds showEditModal + editing{Resource}Id; the child Edit is rendered only while both are set (@if remount per open). On save, Edit dispatches 'zenscafe-toast' and an XUpdated event ->to(Index::class); the parent closes the modal and clears editingXId. Cancel dispatches cancelXEdit to the parent. The Products/Suppliers show pages link 'Edit' to route('index', ['edit' => $id]) so the modal auto-opens.
