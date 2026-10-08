<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate class="rounded-lg">
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Stock Movement') }}</span>
                </div>
                <div class="flex items-center gap-2.5 mt-2">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xs">
                        <flux:icon name="chart-bar" class="size-5" />
                    </span>
                    <h1 class="cafe-page-title">{{ __('Stock Movement Report') }}</h1>
                </div>
                <p class="cafe-page-subtitle">{{ __('Track incoming, outgoing, and adjusted quantities') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-[#E8E4DC] bg-white p-5 shadow-sm dark:border-emerald-950/40 dark:bg-[#12221B]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-stone-100 text-stone-600 dark:bg-emerald-950/40 dark:text-emerald-300">
                        <flux:icon name="rectangle-stack" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-stone-500 dark:text-emerald-300/70">{{ __('Total Transactions') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-[#0D3326] dark:text-emerald-100">{{ $summary['total'] }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-[#D8EDE3] bg-gradient-to-br from-[#EEF8F3] to-[#E3F4EB] p-5 shadow-sm dark:border-emerald-900/40 dark:from-[#132C22] dark:to-[#0D221A]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-xs">
                        <flux:icon name="arrow-down" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-800/80 dark:text-emerald-300/80">{{ __('Stock In') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-50">{{ $summary['stock_in'] }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-[#FFD7D0] bg-gradient-to-br from-[#FFF2F0] to-[#FFE3E0] p-5 shadow-sm dark:border-rose-900/40 dark:from-[#2E1713] dark:to-[#210F0C]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-rose-600 text-white shadow-xs">
                        <flux:icon name="arrow-up" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-rose-800/80 dark:text-rose-300/80">{{ __('Stock Out') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-rose-950 dark:text-rose-50">{{ $summary['stock_out'] }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-[#F3E3BA] bg-gradient-to-br from-[#FEF9ED] to-[#FDF2D7] p-5 shadow-sm dark:border-amber-900/40 dark:from-[#2A2212] dark:to-[#1F190D]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-xs">
                        <flux:icon name="adjustments-horizontal" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-amber-800/80 dark:text-amber-300/80">{{ __('Adjustments') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-amber-950 dark:text-amber-50">{{ $summary['adjustments'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            <div class="p-5 border-b border-[#F1EDE6] dark:border-emerald-950/30">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <flux:field>
                        <flux:label>{{ __('From') }}</flux:label>
                        <flux:input type="date" wire:model.live="dateFrom" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('To') }}</flux:label>
                        <flux:input type="date" wire:model.live="dateTo" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Product') }}</flux:label>
                        <flux:select wire:model.live="product_id">
                            <flux:select.option value="">{{ __('All Products') }}</flux:select.option>
                            @foreach($products as $product)
                                <flux:select.option value="{{ $product->id }}">{{ $product->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Type') }}</flux:label>
                        <flux:select wire:model.live="type">
                            <flux:select.option value="">{{ __('All Types') }}</flux:select.option>
                            <flux:select.option value="stock_in">{{ __('Stock In') }}</flux:select.option>
                            <flux:select.option value="stock_out">{{ __('Stock Out') }}</flux:select.option>
                            <flux:select.option value="adjustment">{{ __('Adjustment') }}</flux:select.option>
                        </flux:select>
                    </flux:field>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="cafe-thead-row">
                            <th class="cafe-th">{{ __('Date') }}</th>
                            <th class="cafe-th">{{ __('Item') }}</th>
                            <th class="cafe-th">{{ __('Type') }}</th>
                            <th class="cafe-th-right">{{ __('Qty') }}</th>
                            <th class="cafe-th-right">{{ __('Previous') }}</th>
                            <th class="cafe-th-right">{{ __('New') }}</th>
                            <th class="cafe-th">{{ __('User') }}</th>
                            <th class="cafe-th">{{ __('Reason') }}</th>
                        </tr>
                    </thead>
                    <tbody class="cafe-tbody">
                        @forelse($transactions as $transaction)
                            @php
                                $type = $transaction->type->value;
                                $pillMap = ['stock_in' => 'border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300', 'stock_out' => 'border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300', 'adjustment' => 'border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300'];
                                $pill = $pillMap[$type] ?? 'border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300';
                                $dotMap = ['stock_in' => 'bg-emerald-500', 'stock_out' => 'bg-rose-500', 'adjustment' => 'bg-amber-500'];
                            @endphp
                            <tr class="cafe-tr">
                                <td class="cafe-td whitespace-nowrap text-stone-500 dark:text-emerald-300/60">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td class="cafe-td font-semibold text-stone-800 dark:text-stone-100">{{ $transaction->product->name }}</td>
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
                                <td class="cafe-td text-xs text-stone-500 dark:text-emerald-300/60">{{ $transaction->reason ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-zinc-500 dark:text-emerald-300/60">{{ __('No transactions found for this period') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>