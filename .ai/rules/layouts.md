---
paths:
  - 'resources/views/layouts/**'
---

# Layouts

## Flux sidebar `collapsible="true"` (string) silently breaks mobile
Always use bare `collapsible` (boolean) or `collapsible="mobile"` on `<flux:sidebar>`. The string `collapsible="true"` fails Flux's strict `$collapsible === true || === 'mobile'` checks, so all mobile off-canvas classes and the backdrop are skipped: the sidebar keeps its 256px grid column at every width, squeezes main content to ~64px, and causes horizontal scroll on phones. Symptom: `[data-flux-main]` width < viewport in a headless-browser check. After any layout edit, verify `document.documentElement.scrollWidth === clientWidth` at 320/768/1280.
