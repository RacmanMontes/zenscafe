<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-xs">
                        <flux:icon name="arrow-down-tray" class="size-5.5" />
                    </span>
                    <div>
                        <h1 class="cafe-page-title">{{ __('Stock In') }}</h1>
                        <p class="cafe-page-subtitle">{{ __('Record incoming inventory') }}</p>
                    </div>
                </div>
            </div>
        </div>

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
                <flux:field>
                    <flux:label>{{ __('Product') }}</flux:label>
                    <flux:select wire:model="product_id">
                        <flux:select.option value="">{{ __('Select a product') }}</flux:select.option>
                        @foreach($products as $product)
                            <flux:select.option value="{{ $product->id }}">
                                {{ $product->name }} ({{ $product->sku }}) — Current: {{ $product->quantity }} {{ $product->unit }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="product_id" />
                </flux:field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Quantity') }}</flux:label>
                        <flux:input type="number" wire:model="quantity" min="1" />
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
                        <flux:input wire:model="reference_number" placeholder="{{ __('Optional reference') }}" />
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