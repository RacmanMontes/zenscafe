<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('products.index')" wire:navigate class="rounded-lg">
                        {{ __('Products') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ $product->name }}</span>
                </div>
                <div class="mt-2 flex items-center gap-3">
                    <span class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-[#F2EFEA] text-stone-600 dark:bg-emerald-950/50 dark:text-emerald-300">
                        <flux:icon name="cube" class="size-6" />
                    </span>
                    <div>
                        <h1 class="cafe-page-title">{{ $product->name }}</h1>
                        <div class="mt-1 text-xs font-mono text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</div>
                    </div>
                </div>
            </div>
            @if($product->status !== 'archived')
                <div class="flex items-center gap-2">
                    <flux:button variant="subtle" icon="pencil" :href="route('products.index', ['edit' => $product->id])" wire:navigate class="rounded-xl">
                        {{ __('Edit') }}
                    </flux:button>
                    <flux:button variant="danger" icon="archive-box" @click="$wire.set('showArchiveModal', true)" class="rounded-xl">
                        {{ __('Archive') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Product Details -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <div class="cafe-card p-6">
                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                <flux:icon name="identification" class="size-4" />
                            </span>
                            <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Product Details') }}</h2>
                        </div>
                        <div>
                            @if($product->status === 'archived')
                                <span class="cafe-status-pill border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                    <span class="cafe-status-pill-dot bg-stone-400"></span>
                                    {{ __('Archived') }}
                                </span>
                            @elseif($product->isOutOfStock())
                                <span class="cafe-status-pill border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300">
                                    <span class="cafe-status-pill-dot bg-rose-500"></span>
                                    {{ __('Out of Stock') }}
                                </span>
                            @elseif($product->isLowStock())
                                <span class="cafe-status-pill border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300">
                                    <span class="cafe-status-pill-dot bg-amber-500"></span>
                                    {{ __('Low Stock') }}
                                </span>
                            @else
                                <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                                    <span class="cafe-status-pill-dot bg-emerald-500"></span>
                                    {{ __('In Stock') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('SKU') }}</div>
                            <div class="mt-1 font-mono font-medium text-stone-800 dark:text-stone-100">{{ $product->sku }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Category') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $product->category->name ?? '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Supplier') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $product->supplier->name ?? '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Unit') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $product->unit }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Cost per Unit') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $product->cost_per_unit !== null ? '$' . number_format($product->cost_per_unit, 2) : '—' }}</div>
                        </div>
                        <div class="rounded-xl bg-[#FAF8F5] p-3.5 dark:bg-emerald-950/30">
                            <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Created') }}</div>
                            <div class="mt-1 font-medium text-stone-800 dark:text-stone-100">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                        @if($product->description)
                            <div class="sm:col-span-2 rounded-xl border border-[#EFEAE3] bg-[#FDFCFA] p-3.5 dark:border-emerald-900/30 dark:bg-emerald-950/20">
                                <div class="text-xs font-bold uppercase tracking-wider text-stone-400 dark:text-emerald-300/50">{{ __('Description') }}</div>
                                <div class="mt-1 text-sm font-medium text-stone-700 dark:text-stone-200">{{ $product->description }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="cafe-card overflow-hidden p-0">
                    <div class="px-5 pt-5 pb-4 border-b border-[#F1EDE6] dark:border-emerald-950/30">
                        <div class="flex items-center gap-2.5">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                <flux:icon name="clock" class="size-4" />
                            </span>
                            <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Transaction History') }}</h2>
                        </div>
                    </div>
                    @if($product->transactions->isEmpty())
                        <div class="cafe-empty-state m-6">
                            <div class="mx-auto flex size-12 items-center justify-center rounded-2xl bg-stone-100 text-stone-400 dark:bg-emerald-950/40 dark:text-emerald-400">
                                <flux:icon name="clock" class="size-6" />
                            </div>
                            <p class="mt-3 text-sm font-medium text-stone-500 dark:text-emerald-300/60">{{ __('No transactions yet') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="cafe-thead-row">
                                        <th class="cafe-th">{{ __('Date') }}</th>
                                        <th class="cafe-th">{{ __('Type') }}</th>
                                        <th class="cafe-th-right">{{ __('Qty') }}</th>
                                        <th class="cafe-th-right">{{ __('Previous') }}</th>
                                        <th class="cafe-th-right">{{ __('New') }}</th>
                                        <th class="cafe-th">{{ __('User') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="cafe-tbody">
                                    @foreach($product->transactions->sortByDesc('created_at') as $transaction)
                                        @php
                                            $type = $transaction->type->value;
                                            $pillMap = ['stock_in' => 'border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300', 'stock_out' => 'border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300', 'adjustment' => 'border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300'];
                                            $pill = $pillMap[$type] ?? 'border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300';
                                            $dotMap = ['stock_in' => 'bg-emerald-500', 'stock_out' => 'bg-rose-500', 'adjustment' => 'bg-amber-500'];
                                        @endphp
                                        <tr class="cafe-tr">
                                            <td class="cafe-td whitespace-nowrap text-stone-500 dark:text-emerald-300/60">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                            <td class="cafe-td">
                                                <span class="cafe-status-pill {{ $pill }}">
                                                    <span class="cafe-status-pill-dot {{ $dotMap[$type] ?? 'bg-stone-400' }}"></span>
                                                    @if($type === 'stock_in') {{ __('Stock In') }}
                                                    @elseif($type === 'stock_out') {{ __('Stock Out') }}
                                                    @else {{ __('Adjustment') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="cafe-td-right font-semibold text-stone-800 dark:text-stone-100">{{ $transaction->quantity }}</td>
                                            <td class="cafe-td-right text-stone-500 dark:text-emerald-300/60">{{ $transaction->previous_quantity }}</td>
                                            <td class="cafe-td-right font-bold text-stone-800 dark:text-stone-100">{{ $transaction->new_quantity }}</td>
                                            <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $transaction->user->name ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Stats -->
            <div class="flex flex-col gap-6">
                <!-- Stock Information -->
                <div class="rounded-2xl border border-[#D8EDE3] bg-gradient-to-br from-[#EEF8F3] to-[#E3F4EB] p-6 shadow-sm dark:border-emerald-900/40 dark:from-[#132C22] dark:to-[#0D221A]">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-emerald-800/80 dark:text-emerald-300/80 mb-4">{{ __('Stock Information') }}</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between rounded-xl bg-white/70 p-3.5 dark:bg-emerald-950/40">
                            <span class="text-sm font-medium text-emerald-900/70 dark:text-emerald-200/70">{{ __('Current Quantity') }}</span>
                            <div class="text-2xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-50">{{ $product->quantity }} <span class="text-sm font-normal text-emerald-700/70 dark:text-emerald-300/60">{{ $product->unitLabel() }}</span></div>
                        </div>
                        <div class="flex items-center justify-between rounded-xl bg-white/70 p-3.5 dark:bg-emerald-950/40">
                            <span class="text-sm font-medium text-emerald-900/70 dark:text-emerald-200/70">{{ __('Minimum Stock') }}</span>
                            <div class="font-bold text-emerald-900 dark:text-emerald-100">{{ $product->min_stock }} {{ $product->unit }}</div>
                        </div>
                        @if($product->max_stock)
                            <div class="flex items-center justify-between rounded-xl bg-white/70 p-3.5 dark:bg-emerald-950/40">
                                <span class="text-sm font-medium text-emerald-900/70 dark:text-emerald-200/70">{{ __('Maximum Stock') }}</span>
                                <div class="font-bold text-emerald-900 dark:text-emerald-100">{{ $product->max_stock }} {{ $product->unit }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Scan Code -->
                <div class="cafe-card p-6">
                    <div class="mb-4 flex items-center gap-2.5">
                        <span class="flex size-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                            <flux:icon name="qr-code" class="size-4" />
                        </span>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Scan Code') }}</h2>
                    </div>
                    <div class="flex flex-col items-center gap-3 rounded-xl bg-white p-4 dark:bg-emerald-950/40">
                        <div class="rounded-xl">{!! app(\App\Services\QrCodeRenderer::class)->render('ZC:'.$product->id, 160) !!}</div>
                        <p class="font-mono text-xs font-medium text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</p>
                        <p class="text-center text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Scan this code at Stock In / Stock Out to select the product automatically.') }}</p>
                    </div>
                </div>

                @if($product->cost_per_unit !== null)
                    <div class="cafe-card p-6">
                        <div class="flex items-center gap-2.5 mb-4">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                                <flux:icon name="banknotes" class="size-4" />
                            </span>
                            <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Stock Value') }}</h2>
                        </div>
                        <div class="text-3xl font-extrabold tracking-tight text-[#0D3326] dark:text-emerald-100">${{ number_format($product->quantity * $product->cost_per_unit, 2) }}</div>
                        <p class="mt-2 text-sm text-stone-500 dark:text-emerald-300/60">
                            {{ $product->quantity }} x ${{ number_format($product->cost_per_unit, 2) }} per {{ $product->unit }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Archive Modal -->
    <flux:modal wire:model="showArchiveModal" class="rounded-2xl p-6">
        <div class="flex items-start gap-3">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400">
                <flux:icon name="archive-box" class="size-5" />
            </span>
            <div>
                <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Archive Product') }}</h3>
                <p class="mt-1.5 text-sm text-stone-500 dark:text-emerald-300/60">
                    {{ __('Are you sure you want to archive :name? This product will no longer appear in active inventory lists.', ['name' => $product->name]) }}
                </p>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-2">
            <flux:button variant="subtle" @click="$wire.set('showArchiveModal', false)" class="rounded-xl">
                {{ __('Cancel') }}
            </flux:button>
            <flux:button variant="danger" wire:click="archive" class="rounded-xl">
                {{ __('Archive') }}
            </flux:button>
        </div>
    </flux:modal>
</div>