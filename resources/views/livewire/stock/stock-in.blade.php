<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-card p-6">
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200/70 bg-emerald-50/70 p-4 text-sm text-emerald-900 dark:border-emerald-800/40 dark:bg-emerald-950/40 dark:text-emerald-200">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-emerald-600/10 text-emerald-700 dark:text-emerald-300">
                    <flux:icon name="arrow-down-tray" class="size-4.5" />
                </span>
                <div>
                    <p class="font-semibold">{{ __('Receive new stock') }}</p>
                    <p class="mt-0.5 text-emerald-800/80 dark:text-emerald-300/70">{{ __('Use this form when products arrive from a supplier. This increases your available quantity.') }}</p>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-6">
                <div
                    class="rounded-xl border border-dashed border-emerald-300/70 bg-emerald-50/40 p-4 dark:border-emerald-800/40 dark:bg-emerald-950/20"
                    x-data="{
                        isScanning: false,
                        startScanner() {
                            this.isScanning = true;
                            $nextTick(() => {
                                ZenQrScanner.start('zen-qr-viewport', (decoded) => {
                                    this.isScanning = false;
                                    $wire.set('scan', decoded);
                                    $wire.handleScan();
                                });
                            });
                        },
                        stopScanner() {
                            this.isScanning = false;
                            ZenQrScanner.stop();
                        },
                    }"
                >
                    <div class="flex items-start gap-3">
                        <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-emerald-600 text-white">
                            <flux:icon name="qr-code" class="size-4.5" />
                        </span>
                        <flux:field class="flex-1">
                            <flux:label>{{ __('Scan Product') }}</flux:label>
                            <div class="flex gap-2">
                                <flux:input wire:model.live="scan" wire:keydown.enter.prevent="handleScan" class="flex-1" placeholder="{{ __('Scan QR or type SKU, then press Enter') }}" />
                                <flux:button type="button" variant="primary" icon="camera" x-on:click="startScanner()" class="shrink-0 rounded-xl">
                                    {{ __('Camera') }}
                                </flux:button>
                            </div>
                            <flux:error name="scan" />
                            <flux:description>{{ __('A successful scan selects the product automatically.') }}</flux:description>
                        </flux:field>
                    </div>

                    <div
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4"
                        x-show="isScanning"
                        x-transition.opacity
                        x-on:keydown.escape.window="stopScanner()"
                        x-on:click.self="stopScanner()"
                        style="display: none"
                    >
                        <div class="w-full max-w-md rounded-2xl bg-white p-4 shadow-xl dark:bg-[#0E1A15] dark:ring-1 dark:ring-emerald-900/40">
                            <div class="mb-3 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-sm font-bold text-[#0D3326] dark:text-emerald-100">
                                    <flux:icon name="qr-code" class="size-4" />
                                    <span>{{ __('Scan with camera') }}</span>
                                </div>
                                <flux:button type="button" variant="subtle" icon="x-mark" size="sm" class="rounded-lg" x-on:click="stopScanner()"></flux:button>
                            </div>
                            <div id="zen-qr-viewport" class="aspect-square w-full overflow-hidden rounded-xl bg-black"></div>
                            <p class="mt-3 text-center text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Point the camera at a product QR code.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Product') }}</flux:label>
                        <flux:select wire:model.live="product_id">
                            <flux:select.option value="">{{ __('Select a product') }}</flux:select.option>
                            @foreach($products as $product)
                                <flux:select.option value="{{ $product->id }}">
                                    {{ $product->name }} ({{ $product->sku }}) — Current: {{ $product->quantity }} {{ $product->unit }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="product_id" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('SKU') }}</flux:label>
                        <flux:input value="{{ $this->selectedSku }}" placeholder="{{ __('Select a product') }}" readonly />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Quantity') }}</flux:label>
                        <flux:input id="stock-in-quantity" type="number" wire:model="quantity" min="1" />
                        <flux:error name="quantity" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Date') }}</flux:label>
                        <flux:input type="date" wire:model="date" />
                        <flux:error name="date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Supplier') }}</flux:label>
                        <flux:select wire:model="supplier_id">
                            <flux:select.option value="">{{ __('Select supplier (optional)') }}</flux:select.option>
                            @foreach($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="supplier_id" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reference Number') }}</flux:label>
                        <flux:input value="{{ $reference_number }}" name="reference_number" readonly />
                        <flux:error name="reference_number" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>{{ __('Notes') }}</flux:label>
                    <flux:textarea wire:model="notes" placeholder="{{ __('Optional notes') }}" rows="2" />
                    <flux:error name="notes" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="arrow-down-on-square" class="rounded-xl">
                        {{ __('Record Stock In') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>