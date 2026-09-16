<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <flux:heading size="xl">{{ __('Products') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Manage your inventory items') }}</flux:text>
            </div>
            <flux:button variant="primary" icon="plus" :href="route('products.create')" wire:navigate>
                {{ __('Add Product') }}
            </flux:button>
        </div>

        <!-- Filters -->
        <flux:card>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search by name or SKU...') }}" icon="magnifying-glass" />
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="categoryFilter">
                        <flux:select.option value="">{{ __('All Categories') }}</flux:select.option>
                        @foreach($categories as $category)
                            <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="supplierFilter">
                        <flux:select.option value="">{{ __('All Suppliers') }}</flux:select.option>
                        @foreach($suppliers as $supplier)
                            <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="statusFilter">
                        <flux:select.option value="">{{ __('All Statuses') }}</flux:select.option>
                        <flux:select.option value="active">{{ __('Active') }}</flux:select.option>
                        <flux:select.option value="archived">{{ __('Archived') }}</flux:select.option>
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="stockFilter">
                        <flux:select.option value="">{{ __('All Stock Levels') }}</flux:select.option>
                        <flux:select.option value="in_stock">{{ __('In Stock') }}</flux:select.option>
                        <flux:select.option value="low_stock">{{ __('Low Stock') }}</flux:select.option>
                        <flux:select.option value="out_of_stock">{{ __('Out of Stock') }}</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
        </flux:card>

        <!-- Products Table -->
        <flux:card>
            @if($products->isEmpty())
                <div class="text-center py-12">
                    <flux:icon name="cube" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:heading size="sm" class="mt-4">{{ __('No products found') }}</flux:heading>
                    <flux:text class="mt-1">{{ __('Get started by adding your first product.') }}</flux:text>
                    <flux:button variant="primary" class="mt-4" :href="route('products.create')" wire:navigate>
                        {{ __('Add Product') }}
                    </flux:button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-3 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('SKU') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Category') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Supplier') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Qty') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Status') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($products as $product)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-3">
                                        <div>
                                            <div class="font-medium" wire:navigate href="{{ route('products.show', $product) }}">
                                                {{ $product->name }}
                                            </div>
                                            @if($product->description)
                                                <div class="text-xs text-zinc-500 truncate max-w-[200px]">{{ $product->description }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 text-zinc-500 font-mono text-xs">{{ $product->sku }}</td>
                                    <td class="py-3">{{ $product->category->name ?? '—' }}</td>
                                    <td class="py-3">{{ $product->supplier->name ?? '—' }}</td>
                                    <td class="py-3 text-right">
                                        <span class="font-medium">{{ $product->quantity }}</span>
                                        <span class="text-zinc-500">{{ $product->unit }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($product->status === 'archived')
                                            <flux:badge color="zinc" size="sm">{{ __('Archived') }}</flux:badge>
                                        @elseif($product->isOutOfStock())
                                            <flux:badge color="red" size="sm">{{ __('Out of Stock') }}</flux:badge>
                                        @elseif($product->isLowStock())
                                            <flux:badge color="yellow" size="sm">{{ __('Low Stock') }}</flux:badge>
                                        @else
                                            <flux:badge color="green" size="sm">{{ __('In Stock') }}</flux:badge>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button variant="subtle" size="sm" icon="eye" :href="route('products.show', $product)" wire:navigate>
                                                {{ __('View') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('products.edit', $product)" wire:navigate>
                                                {{ __('Edit') }}
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</div>