<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate>
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span>{{ __('Current Inventory') }}</span>
                </div>
                <flux:heading size="xl" class="mt-2">{{ __('Current Inventory Report') }}</flux:heading>
            </div>
            <flux:button variant="subtle" icon="printer" @click="window.print()">
                {{ __('Print') }}
            </flux:button>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <flux:card class="flex items-center gap-4">
                <div>
                    <flux:text class="text-sm text-zinc-500">{{ __('Total Items') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalItems }}</div>
                </div>
            </flux:card>
            <flux:card class="flex items-center gap-4">
                <div>
                    <flux:text class="text-sm text-zinc-500">{{ __('Total Quantity') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalQuantity }}</div>
                </div>
            </flux:card>
            <flux:card class="flex items-center gap-4">
                <div>
                    <flux:text class="text-sm text-zinc-500">{{ __('Total Value') }}</flux:text>
                    <div class="text-2xl font-bold">${{ number_format($totalValue, 2) }}</div>
                </div>
            </flux:card>
        </div>

        <flux:card>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mb-4">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search...') }}" icon="magnifying-glass" />
                </flux:field>
                <flux:field>
                    <flux:select wire:model.live="category_id">
                        <flux:select.option value="">{{ __('All Categories') }}</flux:select.option>
                        @foreach($categories as $category)
                            <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
                <flux:field>
                    <flux:select wire:model.live="supplier_id">
                        <flux:select.option value="">{{ __('All Suppliers') }}</flux:select.option>
                        @foreach($suppliers as $supplier)
                            <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="pb-3 text-left font-medium">{{ __('Item') }}</th>
                            <th class="pb-3 text-left font-medium">{{ __('SKU') }}</th>
                            <th class="pb-3 text-left font-medium">{{ __('Category') }}</th>
                            <th class="pb-3 text-left font-medium">{{ __('Supplier') }}</th>
                            <th class="pb-3 text-right font-medium">{{ __('Qty') }}</th>
                            <th class="pb-3 text-right font-medium">{{ __('Min') }}</th>
                            <th class="pb-3 text-right font-medium">{{ __('Unit Cost') }}</th>
                            <th class="pb-3 text-right font-medium">{{ __('Value') }}</th>
                            <th class="pb-3 text-left font-medium">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($products as $product)
                            <tr>
                                <td class="py-2 font-medium">{{ $product->name }}</td>
                                <td class="py-2 font-mono text-xs text-zinc-500">{{ $product->sku }}</td>
                                <td class="py-2">{{ $product->category->name ?? '—' }}</td>
                                <td class="py-2">{{ $product->supplier->name ?? '—' }}</td>
                                <td class="py-2 text-right">{{ $product->quantity }} {{ $product->unit }}</td>
                                <td class="py-2 text-right text-zinc-500">{{ $product->min_stock }}</td>
                                <td class="py-2 text-right">{{ $product->cost_per_unit !== null ? '$' . number_format($product->cost_per_unit, 2) : '—' }}</td>
                                <td class="py-2 text-right font-medium">{{ $product->cost_per_unit !== null ? '$' . number_format($product->quantity * $product->cost_per_unit, 2) : '—' }}</td>
                                <td class="py-2">
                                    @if($product->isOutOfStock())
                                        <flux:badge color="red" size="sm">{{ __('Out of Stock') }}</flux:badge>
                                    @elseif($product->isLowStock())
                                        <flux:badge color="yellow" size="sm">{{ __('Low Stock') }}</flux:badge>
                                    @else
                                        <flux:badge color="green" size="sm">{{ __('In Stock') }}</flux:badge>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-zinc-500">{{ __('No products found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </flux:card>
    </div>
</div>