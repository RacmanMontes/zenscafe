<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate>
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span>{{ __('Low Stock') }}</span>
                </div>
                <flux:heading size="xl" class="mt-2">{{ __('Low Stock Report') }}</flux:heading>
            </div>
        </div>

        <!-- Out of Stock -->
        <flux:card>
            <flux:heading size="sm" class="mb-4 flex items-center gap-2">
                <span class="inline-block size-2 rounded-full bg-red-500"></span>
                {{ __('Out of Stock') }} ({{ $outOfStockProducts->count() }})
            </flux:heading>
            @if($outOfStockProducts->isEmpty())
                <div class="text-center py-6">
                    <flux:text class="text-green-600">{{ __('All products are in stock.') }}</flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-2 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('SKU') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Category') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Min Stock') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Current') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($outOfStockProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-2 font-medium">{{ $product->name }}</td>
                                    <td class="py-2 font-mono text-xs text-zinc-500">{{ $product->sku }}</td>
                                    <td class="py-2">{{ $product->category->name ?? '—' }}</td>
                                    <td class="py-2 text-right text-zinc-500">{{ $product->min_stock }} {{ $product->unit }}</td>
                                    <td class="py-2 text-right text-red-600 font-medium">{{ $product->quantity }} {{ $product->unit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>

        <!-- Low Stock -->
        <flux:card>
            <flux:heading size="sm" class="mb-4 flex items-center gap-2">
                <span class="inline-block size-2 rounded-full bg-yellow-500"></span>
                {{ __('Low Stock') }} ({{ $lowStockProducts->count() }})
            </flux:heading>
            @if($lowStockProducts->isEmpty())
                <div class="text-center py-6">
                    <flux:text class="text-green-600">{{ __('No products are low on stock.') }}</flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-2 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('SKU') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Category') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Min Stock') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Current') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($lowStockProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-2 font-medium">{{ $product->name }}</td>
                                    <td class="py-2 font-mono text-xs text-zinc-500">{{ $product->sku }}</td>
                                    <td class="py-2">{{ $product->category->name ?? '—' }}</td>
                                    <td class="py-2 text-right text-zinc-500">{{ $product->min_stock }} {{ $product->unit }}</td>
                                    <td class="py-2 text-right text-yellow-600 font-medium">{{ $product->quantity }} {{ $product->unit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>
    </div>
</div>