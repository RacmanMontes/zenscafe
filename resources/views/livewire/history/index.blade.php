<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search by product name or SKU...') }}" icon="magnifying-glass" />
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="typeFilter">
                        <flux:select.option value="">{{ __('All Types') }}</flux:select.option>
                        <flux:select.option value="stock_in">{{ __('Stock In') }}</flux:select.option>
                        <flux:select.option value="stock_out">{{ __('Stock Out') }}</flux:select.option>
                        <flux:select.option value="adjustment">{{ __('Adjustment') }}</flux:select.option>
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:input type="date" wire:model.live="dateFrom" placeholder="{{ __('From date') }}" />
                </flux:field>

                <flux:field>
                    <flux:input type="date" wire:model.live="dateTo" placeholder="{{ __('To date') }}" />
                </flux:field>
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            @if($transactions->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        <flux:icon name="clock" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No transactions found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Transaction history will appear here once stock movements are recorded.') }}</p>
                </div>
            @else
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
                                <th class="cafe-th">{{ __('Ref') }}</th>
                                <th class="cafe-th">{{ __('Reason') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($transactions as $transaction)
                                @php
                                    $type = $transaction->type->value;
                                    $typeStyles = [
                                        'stock_in' => ['pill' => 'border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300', 'dot' => 'bg-emerald-500', 'icon' => 'arrow-down', 'sign' => '+', 'signColor' => 'text-emerald-600 dark:text-emerald-400'],
                                        'stock_out' => ['pill' => 'border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300', 'dot' => 'bg-rose-500', 'icon' => 'arrow-up', 'sign' => '-', 'signColor' => 'text-rose-600 dark:text-rose-400'],
                                        'adjustment' => ['pill' => 'border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300', 'dot' => 'bg-amber-500', 'icon' => 'adjustments-horizontal', 'sign' => $transaction->quantity < 0 ? '' : '+', 'signColor' => $transaction->quantity < 0 ? 'text-rose-600 dark:text-rose-400' : 'text-amber-600 dark:text-amber-400'],
                                        'default' => ['pill' => 'border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300', 'dot' => 'bg-stone-400', 'icon' => 'clock', 'sign' => '', 'signColor' => 'text-stone-500'],
                                    ];
                                    $s = $typeStyles[$type] ?? $typeStyles['default'];
                                @endphp
                                <tr class="cafe-tr">
                                    <td class="cafe-td whitespace-nowrap">
                                        <div class="flex items-center gap-1 text-[#0D3326] dark:text-emerald-100">{{ $transaction->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-stone-400 dark:text-emerald-300/50">{{ $transaction->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="cafe-td">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-[#F2EFEA] text-stone-500 dark:bg-emerald-950/50 dark:text-emerald-300">
                                                <flux:icon name="cube" class="size-4" />
                                            </span>
                                            <div>
                                                <a href="{{ route('products.show', $transaction->product) }}" wire:navigate class="font-semibold text-[#1A1A18] hover:text-emerald-800 dark:text-stone-100 dark:hover:text-emerald-300">{{ $transaction->product->name }}</a>
                                                <div class="font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $transaction->product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cafe-td">
                                        <span class="cafe-status-pill {{ $s['pill'] }}">
                                            <span class="cafe-status-pill-dot {{ $s['dot'] }}"></span>
                                            @if($type === 'stock_in') {{ __('Stock In') }}
                                            @elseif($type === 'stock_out') {{ __('Stock Out') }}
                                            @else {{ __('Adjustment') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="cafe-td-right">
                                        <span class="inline-flex items-center gap-1 font-bold {{ $s['signColor'] }}">
                                            <flux:icon name="{{ $s['icon'] }}" class="size-3.5" />
                                            {{ $s['sign'] }}{{ $transaction->quantity }}
                                        </span>
                                    </td>
                                    <td class="cafe-td-right text-stone-500 dark:text-emerald-300/60">{{ $transaction->previous_quantity }}</td>
                                    <td class="cafe-td-right font-bold text-stone-800 dark:text-stone-100">{{ $transaction->new_quantity }}</td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $transaction->user->name ?? '—' }}</td>
                                    <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $transaction->reference_number ?? '—' }}</td>
                                    <td class="cafe-td text-xs text-stone-500 dark:text-emerald-300/60">{{ $transaction->reason ?? '—' }}</td>
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
</div>