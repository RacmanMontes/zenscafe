---
paths:
  - 'resources/views/livewire/**'
---

# Livewire

## Never use flux:select placeholder with wire:model
flux:select `placeholder="..."` renders a DISABLED `<option value="">`. A disabled option can't hold the select's value, so when the model is null the browser visibly pre-selects the FIRST product/option while the model stays null — causing spurious "field is required" on submit (and wrong-looking filters). Always render an explicit selectable empty option instead: `<flux:select.option value="">{{ __('Select...') }}</flux:select.option>` and omit the `placeholder` attribute.
