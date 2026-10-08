<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('products.index')" wire:navigate class="rounded-lg">
                        {{ __('Products') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Add New') }}</span>
                </div>
                <h1 class="cafe-page-title mt-2">{{ __('Add New Product') }}</h1>
                <p class="cafe-page-subtitle">{{ __('Add a new item to your café inventory') }}</p>
            </div>
        </div>

        <div class="cafe-card p-6">
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-200/70 bg-emerald-50/70 p-4 text-sm text-emerald-900 dark:border-emerald-800/40 dark:bg-emerald-950/40 dark:text-emerald-200">
                <flux:icon name="information-circle" class="mt-0.5 size-4.5 shrink-0 text-emerald-700 dark:text-emerald-300" />
                <p>{{ __('Fill in the product details below. Fields marked with validation rules will be checked before saving.') }}</p>
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

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                        {{ __('Create Product') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('products.index')" wire:navigate class="rounded-xl">
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>