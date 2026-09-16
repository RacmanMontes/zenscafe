<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-sm text-zinc-500">
                    <flux:button variant="subtle" size="sm" :href="route('products.index')" wire:navigate>
                        {{ __('Products') }}
                    </flux:button>
                    <span>/</span>
                    <span>{{ $product->name }}</span>
                </div>
                <flux:heading size="xl" class="mt-2">{{ $product->name }}</flux:heading>
            </div>
            <div class="flex items-center gap-2">
                @if($product->status !== 'archived')
                    <flux:button variant="subtle" icon="pencil" :href="route('products.edit', $product)" wire:navigate>
                        {{ __('Edit') }}
                    </flux:button>
                    <flux:button variant="danger" icon="archive-box" @click="$wire.set('showArchiveModal', true)">
                        {{ __('Archive') }}
                    </flux:button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Product Details -->
            <div class="lg:col-span-2">
                <flux:card>
                    <flux:heading size="sm" class="mb-4">{{ __('Product Details') }}</flux:heading>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('SKU') }}</flux:text>
                            <div class="font-mono">{{ $product->sku }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Category') }}</flux:text>
                            <div>{{ $product->category->name ?? '—' }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Supplier') }}</flux:text>
                            <div>{{ $product->supplier->name ?? '—' }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Unit') }}</flux:text>
                            <div>{{ $product->unit }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Cost per Unit') }}</flux:text>
                            <div>{{ $product->cost_per_unit !== null ? '$' . number_format($product->cost_per_unit, 2) : '—' }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Status') }}</flux:text>
                            <div>
                                @if($product->status === 'archived')
                                    <flux:badge color="zinc">{{ __('Archived') }}</flux:badge>
                                @elseif($product->isOutOfStock())
                                    <flux:badge color="red">{{ __('Out of Stock') }}</flux:badge>
                                @elseif($product->isLowStock())
                                    <flux:badge color="yellow">{{ __('Low Stock') }}</flux:badge>
                                @else
                                    <flux:badge color="green">{{ __('In Stock') }}</flux:badge>
                                @endif
                            </div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Created') }}</flux:text>
                            <div>{{ $product->created_at->format('M d, Y') }}</div>
                        </div>
                        <div>
                            <flux:text class="text-sm font-medium text-zinc-500">{{ __('Last Updated') }}</flux:text>
                            <div>{{ $product->updated_at->format('M d, Y') }}</div>
                        </div>
                        @if($product->description)
                            <div class="sm:col-span-2">
                                <flux:text class="text-sm font-medium text-zinc-500">{{ __('Description') }}</flux:text>
                                <div>{{ $product->description }}</div>
                            </div>
                        @endif
                    </div>
                </flux:card>

                <!-- Transaction History -->
                <flux:card class="mt-6">
                    <flux:heading size="sm" class="mb-4">{{ __('Transaction History') }}</flux:heading>
                    @if($product->transactions->isEmpty())
                        <div class="text-center py-6">
                            <flux:text class="text-zinc-500">{{ __('No transactions yet') }}</flux:text>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                        <th class="pb-2 text-left font-medium">{{ __('Date') }}</th>
                                        <th class="pb-2 text-left font-medium">{{ __('Type') }}</th>
                                        <th class="pb-2 text-right font-medium">{{ __('Qty') }}</th>
                                        <th class="pb-2 text-right font-medium">{{ __('Previous') }}</th>
                                        <th class="pb-2 text-right font-medium">{{ __('New') }}</th>
                                        <th class="pb-2 text-left font-medium">{{ __('User') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                                    @foreach($product->transactions->sortByDesc('created_at') as $transaction)
                                        <tr>
                                            <td class="py-2">{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                            <td class="py-2">
                                                @if($transaction->type->value === 'stock_in')
                                                    <flux:badge color="green" size="sm">{{ __('Stock In') }}</flux:badge>
                                                @elseif($transaction->type->value === 'stock_out')
                                                    <flux:badge color="red" size="sm">{{ __('Stock Out') }}</flux:badge>
                                                @else
                                                    <flux:badge color="yellow" size="sm">{{ __('Adjustment') }}</flux:badge>
                                                @endif
                                            </td>
                                            <td class="py-2 text-right">{{ $transaction->quantity }}</td>
                                            <td class="py-2 text-right text-zinc-500">{{ $transaction->previous_quantity }}</td>
                                            <td class="py-2 text-right font-medium">{{ $transaction->new_quantity }}</td>
                                            <td class="py-2">{{ $transaction->user->name ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </flux:card>
            </div>

            <!-- Sidebar Stats -->
            <div class="flex flex-col gap-6">
                <flux:card>
                    <flux:heading size="sm" class="mb-4">{{ __('Stock Information') }}</flux:heading>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <flux:text class="text-sm">{{ __('Current Quantity') }}</flux:text>
                            <div class="text-2xl font-bold">{{ $product->quantity }} <span class="text-sm font-normal text-zinc-500">{{ $product->unit }}</span></div>
                        </div>
                        <div class="flex items-center justify-between">
                            <flux:text class="text-sm">{{ __('Minimum Stock') }}</flux:text>
                            <div>{{ $product->min_stock }} {{ $product->unit }}</div>
                        </div>
                        @if($product->max_stock)
                            <div class="flex items-center justify-between">
                                <flux:text class="text-sm">{{ __('Maximum Stock') }}</flux:text>
                                <div>{{ $product->max_stock }} {{ $product->unit }}</div>
                            </div>
                        @endif
                    </div>
                </flux:card>

                @if($product->cost_per_unit)
                    <flux:card>
                        <flux:heading size="sm" class="mb-4">{{ __('Stock Value') }}</flux:heading>
                        <div class="text-2xl font-bold">${{ number_format($product->quantity * $product->cost_per_unit, 2) }}</div>
                        <flux:text class="text-sm text-zinc-500 mt-1">
                            {{ $product->quantity }} x ${{ number_format($product->cost_per_unit, 2) }} per {{ $product->unit }}
                        </flux:text>
                    </flux:card>
                @endif
            </div>
        </div>
    </div>

    <!-- Archive Modal -->
    <flux:modal wire:model="showArchiveModal">
        <flux:heading>{{ __('Archive Product') }}</flux:heading>
        <flux:text class="mt-2">
            {{ __('Are you sure you want to archive :name? This product will no longer appear in active inventory lists.', ['name' => $product->name]) }}
        </flux:text>
        <div class="mt-6 flex justify-end gap-2">
            <flux:button variant="subtle" @click="$wire.set('showArchiveModal', false)">
                {{ __('Cancel') }}
            </flux:button>
            <flux:button variant="danger" wire:click="archive">
                {{ __('Archive') }}
            </flux:button>
        </div>
    </flux:modal>
</div>