---
paths:
  - 'app/Livewire/Stock/**,resources/views/livewire/stock/**,resources/js/**,app/Models/Product.php'
---

# Models

## Stock form QR scanning: ZC payload + camera via ZenQrScanner
Stock forms (Stock In/Stock Out/Adjustment) support two lookup modes: (1) a USB keyboard-emulation scanner or manual SKU typed into the 'scan' input + Enter calls handleScan(); (2) a 'Camera' button opens an Alpine overlay using window.ZenQrScanner (html5-qrcode, bundled via resources/js/zen-qr-scanner.js) that decodes and calls $wire.set('scan', ...) then $wire.handleScan(). handleScan resolves via Product::resolveByScan(): QRs encode the IMMUTABLE payload 'ZC:<product_id>' (product-page QR renders app\Services\QrCodeRenderer::render('ZC:'.$id), sku shown as caption only), while plain text is matched against sku (UPPER, active products only). After success the scan field clears, product_id is set, and focus jumps to the quantity/adjustment input via $this->js(). Never encode the human SKU in the QR; keep the ZC: payload so labels survive SKU edits.
