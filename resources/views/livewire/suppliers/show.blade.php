<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('suppliers.index')" wire:navigate class="rounded-lg">
                        {{ __('Suppliers') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ $supplier->name }}</span>
                </div>
                <div class="mt-2 flex items-center gap-2.5">
                    <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100 text-cyan-700 dark:from-cyan-900/40 dark:to-sky-900/40 dark:text-cyan-300">
                        <flux:icon name="building-storefront" class="size-5.5" />
                    </span>
                    <h1 class="cafe-page-title">{{ $supplier->name }}</h1>
                </div>
            </div>
            <flux:button variant="subtle" icon="pencil" :href="route('suppliers.edit', $supplier)" wire:navigate class="rounded-xl">
                {{ __('Edit') }}
            </flux:button>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Order History -->
            <div class="lg:col-span-2">
                <div class="cafe-card overflow-hidden p-0">
                    <div class="px-5 pt-5 pb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-[#F1EDE6] dark:border-emerald-950/30">
                        <div class="flex items-center gap-2.5">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                <flux:icon name="clock" class="size-4" />
                            </span>
                            <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Order History') }}</h2>
                        </div>
                        <flux:input wire:model.live="search" placeholder="{{ __('Search by item or SKU...') }}" icon="magnifying-glass" class="sm:w-72 rounded-xl" />
                    </div>

                    @if($transactions->isEmpty())
                        <div class="cafe-empty-state m-6">
                            <div class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-stone-100 text-stone-400 dark:bg-emerald-950/40 dark:text-emerald-400">
                                <flux:icon name="clock" class="size-6" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-stone-500 dark:text-emerald-300/60">{{ __('No stock-in transactions for this supplier yet.') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="cafe-thead-row">
                                        <th class="cafe-th">{{ __('Date') }}</th>
                                        <th class="cafe-th">{{ __('Item') }}</th>
                                        <th class="cafe-th-right">{{ __('Qty') }}</th>
                                        <th class="cafe-th">{{ __('Reference') }}</th>
                                        <th class="cafe-th">{{ __('Recorded By') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="cafe-tbody">
                                    @foreach($transactions as $transaction)
                                        <tr class="cafe-tr">
                                            <td class="cafe-td whitespace-nowrap text-stone-500 dark:text-emerald-300/60">{{ $transaction->transacted_at?->format('M d, Y') }}</td>
                                            <td class="cafe-td">
                                                <a href="{{ route('products.show', $transaction->product) }}" wire:navigate class="font-semibold text-[#1A1A18] hover:text-emerald-800 dark:text-stone-100 dark:hover:text-emerald-300">
                                                    {{ $transaction->product->name }}
                                                </a>
                                                <div class="text-xs font-mono text-stone-500 dark:text-emerald-300/60">{{ $transaction->product->sku }}</div>
                                            </td>
                                            <td class="cafe-td-right">
                                                <span class="inline-flex items-center gap-1 rounded-full border border-emerald-200/80 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                                                    <flux:icon name="arrow-down" class="size-3" />
                                                    {{ $transaction->quantity }} {{ $transaction->product->unit }}
                                                </span>
                                            </td>
                                            <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $transaction->reference_number ?? '—' }}</td>
                                            <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $transaction->user->name ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 border-t border-[#F1EDE6] px-4 py-4 dark:border-emerald-950/30">
                            {{ $transactions->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Supplier Sidebar -->
            <div class="flex flex-col gap-6">
                <div class="cafe-card p-6">
                    <div class="mb-4 flex items-center gap-2.5">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-cyan-100 text-cyan-800 dark:bg-cyan-900/40 dark:text-cyan-300">
                            <flux:icon name="identification" class="size-4" />
                        </span>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Contact Details') }}</h2>
                    </div>
                    <div class="space-y-4">
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Contact Person') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $supplier->contact_person ?? '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Email') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $supplier->email ?? '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Phone') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $supplier->phone ?? '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Address') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $supplier->address ?? '—' }}</div>
                        </div>
                        @if($supplier->notes)
                            <div class="rounded-xl border border-amber-200/60 bg-amber-50/70 p-3.5 dark:border-amber-900/30 dark:bg-amber-950/30">
                                <div class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">{{ __('Notes') }}</div>
                                <div class="mt-1 text-sm font-medium text-amber-900 dark:text-amber-200">{{ $supplier->notes }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="cafe-card p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300">
                                <flux:icon name="cube" class="size-4" />
                            </span>
                            <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Supplied Items') }}</h2>
                        </div>
                        <span class="rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-semibold text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $products->count() }}</span>
                    </div>
                    @if($products->isEmpty())
                        <p class="text-sm text-stone-500 dark:text-emerald-300/60">{{ __('No products assigned.') }}</p>
                    @else
                        <ul class="divide-y divide-[#F1EDE6] dark:divide-emerald-950/30">
                            @foreach($products as $product)
                                <li>
                                    <a href="{{ route('products.show', $product) }}" wire:navigate class="flex items-center justify-between gap-2 py-2.5 transition-colors hover:text-emerald-800 dark:hover:text-emerald-300">
                                        <div class="min-w-0">
                                            <div class="truncate font-medium text-stone-800 dark:text-stone-100">{{ $product->name }}</div>
                                            <div class="truncate text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->category?->name ?? '—' }}</div>
                                        </div>
                                        <div class="shrink-0 text-right text-sm font-semibold text-stone-700 dark:text-stone-300">
                                            {{ $product->quantity }} <span class="text-xs font-normal text-stone-500 dark:text-emerald-300/60">{{ $product->unit }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>