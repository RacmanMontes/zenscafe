<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-xs">
                        <flux:icon name="chart-bar" class="size-5" />
                    </span>
                    <h1 class="cafe-page-title">{{ __('Reports') }}</h1>
                </div>
                <p class="cafe-page-subtitle">{{ __('Generate and view inventory reports') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('reports.current-inventory') }}" wire:navigate class="group cafe-card p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white shadow-xs transition-transform group-hover:scale-105">
                        <flux:icon name="cube" class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Current Inventory') }}</h2>
                        <p class="mt-0.5 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('View all current stock levels') }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    {{ __('Open report') }}
                    <flux:icon name="arrow-right" class="size-3 transition-transform group-hover:translate-x-0.5" />
                </div>
            </a>

            <a href="{{ route('reports.low-stock') }}" wire:navigate class="group cafe-card p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 text-white shadow-xs transition-transform group-hover:scale-105">
                        <flux:icon name="exclamation-triangle" class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Low Stock Report') }}</h2>
                        <p class="mt-0.5 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Items that need restocking') }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    {{ __('Open report' )}}
                    <flux:icon name="arrow-right" class="size-3 transition-transform group-hover:translate-x-0.5" />
                </div>
            </a>

            <a href="{{ route('reports.stock-movement') }}" wire:navigate class="group cafe-card p-6 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-xs transition-transform group-hover:scale-105">
                        <flux:icon name="chart-bar" class="size-6" />
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Stock Movement') }}</h2>
                        <p class="mt-0.5 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Stock in/out and adjustments') }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5 text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    {{ __('Open report') }}
                    <flux:icon name="arrow-right" class="size-3 transition-transform group-hover:translate-x-0.5" />
                </div>
            </a>
        </div>
    </div>
</div>