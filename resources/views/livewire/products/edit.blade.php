<div>
    <div class="flex w-full flex-col gap-6">
        <div class="flex items-center gap-3">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                <flux:icon name="cube" class="size-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Edit Product') }}</h3>
                <p class="text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Update details for :name', ['name' => $product->name]) }}</p>
            </div>
        </div>

        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <flux:field>
                    <flux:label>{{ __('Product Name') }}</flux:label>
                    <flux:input wire:model="name" placeholder="{{ __('Enter product name') }}" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('SKU') }}</flux:label>
                    <flux:input wire:model="sku" placeholder="{{ __('Enter SKU') }}" />
                    <flux:error name="sku" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Category') }}</flux:label>
                    <flux:select wire:model="category_id">
                        <flux:select.option value="">{{ __('Select a category') }}</flux:select.option>
                        @foreach($categories as $category)
                            <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Supplier') }}</flux:label>
                    <flux:select wire:model="supplier_id">
                        <flux:select.option value="">{{ __('Select a supplier (optional)') }}</flux:select.option>
                        @foreach($suppliers as $supplier)
                            <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="supplier_id" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Unit') }}</flux:label>
                    <flux:input wire:model="unit" placeholder="{{ __('e.g., pcs, kg, L') }}" />
                    <flux:error name="unit" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Status') }}</flux:label>
                    <flux:select wire:model="status">
                        <flux:select.option value="active">{{ __('Active') }}</flux:select.option>
                        <flux:select.option value="archived">{{ __('Archived') }}</flux:select.option>
                    </flux:select>
                    <flux:error name="status" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Current Quantity') }}</flux:label>
                    <flux:input type="number" wire:model="quantity" min="0" />
                    <flux:error name="quantity" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Minimum Stock Level') }}</flux:label>
                    <flux:input type="number" wire:model="min_stock" min="0" />
                    <flux:error name="min_stock" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Maximum Stock Level') }}</flux:label>
                    <flux:input type="number" wire:model="max_stock" min="0" placeholder="{{ __('Optional') }}" />
                    <flux:error name="max_stock" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Cost per Unit') }}</flux:label>
                    <flux:input type="number" wire:model="cost_per_unit" min="0" step="0.01" placeholder="{{ __('Optional') }}" />
                    <flux:error name="cost_per_unit" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Description') }}</flux:label>
                <flux:textarea wire:model="description" placeholder="{{ __('Optional product description') }}" rows="3" />
                <flux:error name="description" />
            </flux:field>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                <flux:button variant="subtle" wire:click="cancelEdit" class="rounded-xl">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                    {{ __('Update Product') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>