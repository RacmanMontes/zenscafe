<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate class="rounded-lg">
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Low Stock') }}</span>
                </div>
                <div class="flex items-center gap-2.5 mt-2">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-xs">
                        <flux:icon name="exclamation-triangle" class="size-5" />
                    </span>
                    <h1 class="cafe-page-title">{{ __('Low Stock Report') }}</h1>
                </div>
                <p class="cafe-page-subtitle">{{ __('Items that need your attention') }}</p>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="cafe-card overflow-hidden p-0">
            <div class="px-5 pt-5 pb-4 border-b border-[#F1EDE6] dark:border-emerald-950/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">
                            <flux:icon name="no-symbol" class="size-4" />
                        </span>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Out of Stock') }}</h2>
                    </div>
                    <span class="rounded-full border border-rose-200/80 bg-rose-50 px-2.5 py-0.5 text-xs font-semibold text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300">{{ $outOfStockProducts->count() }}</span>
                </div>
            </div>
            @if($outOfStockProducts->isEmpty())
                <div class="cafe-empty-state m-6">
                    <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                        <span class="cafe-status-pill-dot bg-emerald-500"></span>
                        {{ __('All products are in stock.') }}
                    </span>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Item') }}</th>
                                <th class="cafe-th">{{ __('SKU') }}</th>
                                <th class="cafe-th">{{ __('Category') }}</th>
                                <th class="cafe-th-right">{{ __('Min Stock') }}</th>
                                <th class="cafe-th-right">{{ __('Current') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($outOfStockProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cafe-tr cursor-pointer">
                                    <td class="cafe-td font-semibold text-[#1A1A18] dark:text-stone-100">{{ $product->name }}</td>
                                    <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                            {{ $product->category->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="cafe-td-right text-stone-500 dark:text-emerald-300/60">{{ $product->min_stock }} {{ $product->unit }}</td>
                                    <td class="cafe-td-right">
                                        <span class="inline-flex items-center gap-1 font-bold text-rose-600 dark:text-rose-400">
                                            <flux:icon name="no-symbol" class="size-3.5" />
                                            {{ $product->quantity }} {{ $product->unit }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Low Stock -->
        <div class="cafe-card overflow-hidden p-0">
            <div class="px-5 pt-5 pb-4 border-b border-[#F1EDE6] dark:border-emerald-950/30">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">
                            <flux:icon name="exclamation-triangle" class="size-4" />
                        </span>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Low Stock') }}</h2>
                    </div>
                    <span class="rounded-full border border-amber-200/80 bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300">{{ $lowStockProducts->count() }}</span>
                </div>
            </div>
            @if($lowStockProducts->isEmpty())
                <div class="cafe-empty-state m-6">
                    <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                        <span class="cafe-status-pill-dot bg-emerald-500"></span>
                        {{ __('No products are low on stock.') }}
                    </span>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Item') }}</th>
                                <th class="cafe-th">{{ __('SKU') }}</th>
                                <th class="cafe-th">{{ __('Category') }}</th>
                                <th class="cafe-th-right">{{ __('Min Stock') }}</th>
                                <th class="cafe-th-right">{{ __('Current') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($lowStockProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cafe-tr cursor-pointer">
                                    <td class="cafe-td font-semibold text-[#1A1A18] dark:text-stone-100">{{ $product->name }}</td>
                                    <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                            {{ $product->category->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="cafe-td-right text-stone-500 dark:text-emerald-300/60">{{ $product->min_stock }} {{ $product->unit }}</td>
                                    <td class="cafe-td-right">
                                        <span class="inline-flex items-center gap-1 font-bold text-amber-600 dark:text-amber-400">
                                            <flux:icon name="exclamation-triangle" class="size-3.5" />
                                            {{ $product->quantity }} {{ $product->unit }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>