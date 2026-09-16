<div>
    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl">{{ __('Inventory History') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Complete record of all inventory transactions') }}</flux:text>
        </div>

        <flux:card>
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
        </flux:card>

        <flux:card>
            @if($transactions->isEmpty())
                <div class="text-center py-12">
                    <flux:icon name="clock" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:heading size="sm" class="mt-4">{{ __('No transactions found') }}</flux:heading>
                    <flux:text class="mt-1">{{ __('Transaction history will appear here once stock movements are recorded.') }}</flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-3 text-left font-medium">{{ __('Date') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Type') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Qty') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Previous') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('New') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('User') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Ref') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Reason') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td class="py-3 whitespace-nowrap">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                    <td class="py-3">
                                        <div class="font-medium">{{ $transaction->product->name }}</div>
                                        <div class="text-xs text-zinc-500 font-mono">{{ $transaction->product->sku }}</div>
                                    </td>
                                    <td class="py-3">
                                        @if($transaction->type->value === 'stock_in')
                                            <flux:badge color="green" size="sm">{{ __('Stock In') }}</flux:badge>
                                        @elseif($transaction->type->value === 'stock_out')
                                            <flux:badge color="red" size="sm">{{ __('Stock Out') }}</flux:badge>
                                        @else
                                            <flux:badge color="yellow" size="sm">{{ __('Adjustment') }}</flux:badge>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right font-medium">{{ $transaction->quantity }}</td>
                                    <td class="py-3 text-right text-zinc-500">{{ $transaction->previous_quantity }}</td>
                                    <td class="py-3 text-right font-medium">{{ $transaction->new_quantity }}</td>
                                    <td class="py-3">{{ $transaction->user->name ?? '—' }}</td>
                                    <td class="py-3 text-zinc-500 font-mono text-xs">{{ $transaction->reference_number ?? '—' }}</td>
                                    <td class="py-3 text-zinc-500 text-xs">{{ $transaction->reason ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</div>