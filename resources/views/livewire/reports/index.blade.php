<div>
    <div class="flex flex-col gap-6">
        <div>
            <flux:heading size="xl">{{ __('Reports') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Generate and view inventory reports') }}</flux:text>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <flux:card class="hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                <a href="{{ route('reports.current-inventory') }}" wire:navigate class="block">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                            <flux:icon name="cube" class="size-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div>
                            <flux:heading size="sm">{{ __('Current Inventory') }}</flux:heading>
                            <flux:text class="text-sm">{{ __('View all current stock levels') }}</flux:text>
                        </div>
                    </div>
                </a>
            </flux:card>

            <flux:card class="hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                <a href="{{ route('reports.low-stock') }}" wire:navigate class="block">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                            <flux:icon name="exclamation-triangle" class="size-6 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div>
                            <flux:heading size="sm">{{ __('Low Stock Report') }}</flux:heading>
                            <flux:text class="text-sm">{{ __('Items that need restocking') }}</flux:text>
                        </div>
                    </div>
                </a>
            </flux:card>

            <flux:card class="hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
                <a href="{{ route('reports.stock-movement') }}" wire:navigate class="block">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30">
                            <flux:icon name="chart-bar" class="size-6 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <flux:heading size="sm">{{ __('Stock Movement') }}</flux:heading>
                            <flux:text class="text-sm">{{ __('Stock in/out and adjustments') }}</flux:text>
                        </div>
                    </div>
                </a>
            </flux:card>
        </div>
    </div>
</div>