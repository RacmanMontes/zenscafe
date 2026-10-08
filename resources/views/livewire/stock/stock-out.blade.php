<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-card p-6">
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-rose-200/70 bg-rose-50/70 p-4 text-sm text-rose-900 dark:border-rose-800/40 dark:bg-rose-950/40 dark:text-rose-200">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-rose-600/10 text-rose-700 dark:text-rose-300">
                    <flux:icon name="arrow-up-tray" class="size-4.5" />
                </span>
                <div>
                    <p class="font-semibold">{{ __('Dispatch / consume stock') }}</p>
                    <p class="mt-0.5 text-rose-800/80 dark:text-rose-300/70">{{ __('Use this form when inventory leaves the café (sales, consumption, waste). This decreases your available quantity.') }}</p>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Product') }}</flux:label>
                        <flux:select wire:model.live="product_id">
                            <flux:select.option value="">{{ __('Select a product') }}</flux:select.option>
                            @foreach($products as $product)
                                <flux:select.option value="{{ $product->id }}">
                                    {{ $product->name }} ({{ $product->sku }}) — Available: {{ $product->quantity }} {{ $product->unit }}
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
                        <flux:input type="number" wire:model="quantity" min="1" />
                        <flux:error name="quantity" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Date') }}</flux:label>
                        <flux:input type="date" wire:model="date" />
                        <flux:error name="date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reason') }}</flux:label>
                        <flux:input wire:model="reason" placeholder="{{ __('e.g., Sale, Consumption, Waste') }}" />
                        <flux:error name="reason" />
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
                    <flux:button type="submit" variant="danger" icon="arrow-up-on-square" class="rounded-xl">
                        {{ __('Record Stock Out') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>