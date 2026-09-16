<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate>
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span>{{ __('Stock Movement') }}</span>
                </div>
                <flux:heading size="xl" class="mt-2">{{ __('Stock Movement Report') }}</flux:heading>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <flux:card>
                <flux:text class="text-sm text-zinc-500">{{ __('Total Transactions') }}</flux:text>
                <div class="text-2xl font-bold">{{ $summary['total'] }}</div>
            </flux:card>
            <flux:card>
                <flux:text class="text-sm text-zinc-500">{{ __('Stock In') }}</flux:text>
                <div class="text-2xl font-bold text-green-600">{{ $summary['stock_in'] }}</div>
            </flux:card>
            <flux:card>
                <flux:text class="text-sm text-zinc-500">{{ __('Stock Out') }}</flux:text>
                <div class="text-2xl font-bold text-red-600">{{ $summary['stock_out'] }}</div>
            </flux:card>
            <flux:card>
                <flux:text class="text-sm text-zinc-500">{{ __('Adjustments') }}</flux:text>
                <div class="text-2xl font-bold text-yellow-600">{{ $summary['adjustments'] }}</div>
            </flux:card>
        </div>

        <flux:card>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mb-4">
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
                    <flux:select wire:model.live="product_id" placeholder="{{ __('All Products') }}">
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
                            <th class="pb-3 text-left font-medium">{{ __('Reason') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($transactions as $transaction)
                            <tr>
                                <td class="py-2 whitespace-nowrap">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                <td class="py-2 font-medium">{{ $transaction->product->name }}</td>
                                <td class="py-2">
                                    @if($transaction->type->value === 'stock_in')
                                        <flux:badge color="green" size="sm">{{ __('Stock In') }}</flux:badge>
                                    @elseif($transaction->type->value === 'stock_out')
                                        <flux:badge color="red" size="sm">{{ __('Stock Out') }}</flux:badge>
                                    @else
                                        <flux:badge color="yellow" size="sm">{{ __('Adjustment') }}</flux:badge>
                                    @endif
                                </td>
                                <td class="py-2 text-right font-medium">{{ $transaction->quantity }}</td>
                                <td class="py-2 text-right text-zinc-500">{{ $transaction->previous_quantity }}</td>
                                <td class="py-2 text-right font-medium">{{ $transaction->new_quantity }}</td>
                                <td class="py-2">{{ $transaction->user->name ?? '—' }}</td>
                                <td class="py-2 text-zinc-500 text-xs">{{ $transaction->reason ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-8 text-center text-zinc-500">{{ __('No transactions found for this period') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </flux:card>
    </div>
</div>