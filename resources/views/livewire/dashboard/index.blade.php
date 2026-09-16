<div>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div>
            <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Welcome to Zen\'s Cafe Inventory Management System') }}</flux:text>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <flux:icon name="cube" class="size-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Total Items') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalProducts }}</div>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                    <flux:icon name="folder" class="size-6 text-purple-600 dark:text-purple-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Categories') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalCategories }}</div>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                    <flux:icon name="truck" class="size-6 text-green-600 dark:text-green-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Suppliers') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalSuppliers }}</div>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                    <flux:icon name="exclamation-triangle" class="size-6 text-yellow-600 dark:text-yellow-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Low Stock') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $lowStockCount }}</div>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/30">
                    <flux:icon name="no-symbol" class="size-6 text-red-600 dark:text-red-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Out of Stock') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $outOfStockCount }}</div>
                </div>
            </flux:card>

            <flux:card class="flex items-center gap-4">
                <div class="flex size-12 items-center justify-center rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                    <flux:icon name="users" class="size-6 text-indigo-600 dark:text-indigo-400" />
                </div>
                <div>
                    <flux:text class="text-sm">{{ __('Users') }}</flux:text>
                    <div class="text-2xl font-bold">{{ $totalUsers }}</div>
                </div>
            </flux:card>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Stock Movement Chart -->
            <flux:card>
                <flux:heading size="sm" class="mb-4">{{ __('Stock Movements (Last 7 Days)') }}</flux:heading>
                <div wire:ignore x-data="{ chart: null }" x-init="
                    const options = {
                        chart: { type: 'bar', height: 300, toolbar: { show: false } },
                        series: [
                            { name: 'Stock In', data: {{ $stockMovements->pluck('stock_in_total')->toJson() }} },
                            { name: 'Stock Out', data: {{ $stockMovements->pluck('stock_out_total')->toJson() }} }
                        ],
                        xaxis: { categories: {{ $stockMovements->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toJson() }} },
                        colors: ['#22c55e', '#ef4444'],
                        plotOptions: { bar: { borderRadius: 4 } },
                        dataLabels: { enabled: false },
                        legend: { position: 'bottom' }
                    };
                    chart = new ApexCharts($el, options);
                    chart.render();
                "></div>
            </flux:card>

            <!-- Category Distribution Chart -->
            <flux:card>
                <flux:heading size="sm" class="mb-4">{{ __('Items by Category') }}</flux:heading>
                <div wire:ignore x-data="{ chart: null }" x-init="
                    const options = {
                        chart: { type: 'donut', height: 300 },
                        series: {{ $categoryDistribution->pluck('count')->toJson() }},
                        labels: {{ $categoryDistribution->pluck('category.name')->map(fn($n) => $n ?? 'Uncategorized')->toJson() }},
                        colors: ['#3b82f6', '#8b5cf6', '#06b6d4', '#f59e0b', '#ef4444', '#10b981', '#ec4899'],
                        legend: { position: 'bottom' },
                        dataLabels: { enabled: false }
                    };
                    chart = new ApexCharts($el, options);
                    chart.render();
                "></div>
            </flux:card>
        </div>

        <!-- Recent Transactions -->
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">{{ __('Recent Transactions') }}</flux:heading>
                <flux:button variant="subtle" size="sm" :href="route('inventory-history')" wire:navigate>
                    {{ __('View All') }}
                </flux:button>
            </div>

            @if($recentTransactions->isEmpty())
                <div class="text-center py-8">
                    <flux:icon name="clock" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:text class="mt-2">{{ __('No transactions yet') }}</flux:text>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-2 text-left font-medium">{{ __('Date') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Type') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Qty') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('User') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td class="py-2">{{ $transaction->created_at->format('M d, Y') }}</td>
                                    <td class="py-2">{{ $transaction->product->name }}</td>
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
                                    <td class="py-2">{{ $transaction->user->name ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>

        <!-- Recently Added Products -->
        <flux:card>
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">{{ __('Recently Added Products') }}</flux:heading>
                <flux:button variant="subtle" size="sm" :href="route('products.index')" wire:navigate>
                    {{ __('View All') }}
                </flux:button>
            </div>

            @if($recentProducts->isEmpty())
                <div class="text-center py-8">
                    <flux:icon name="cube" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:text class="mt-2">{{ __('No products yet') }}</flux:text>
                    <flux:button variant="primary" size="sm" class="mt-3" :href="route('products.create')" wire:navigate>
                        {{ __('Add Product') }}
                    </flux:button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-2 text-left font-medium">{{ __('Item') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Category') }}</th>
                                <th class="pb-2 text-right font-medium">{{ __('Qty') }}</th>
                                <th class="pb-2 text-left font-medium">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($recentProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-2 font-medium">{{ $product->name }}</td>
                                    <td class="py-2">{{ $product->category->name ?? '—' }}</td>
                                    <td class="py-2 text-right">{{ $product->quantity }} {{ $product->unit }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </flux:card>
    </div>
</div>