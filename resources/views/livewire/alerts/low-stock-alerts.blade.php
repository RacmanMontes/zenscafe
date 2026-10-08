<div class="contents" x-data="{ open: false }" wire:poll.30s>
    <flux:button variant="subtle" icon="bell" class="relative rounded-xl text-stone-600 hover:bg-emerald-50 hover:text-emerald-800 dark:text-stone-300 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-300 transition-colors" @click="open = !open" aria-label="{{ __('Low stock alerts') }}">
        @if($unreadCount > 0)
            <span class="absolute -right-0.5 -top-0.5 flex size-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-bold text-white shadow-xs animate-pulse">
                {{ min($unreadCount, 99) }}
            </span>
        @endif
    </flux:button>

    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        wire:key="alerts-panel"
        class="absolute z-50 top-full mt-2 w-80 max-w-[calc(100vw-2rem)] overflow-hidden rounded-2xl border border-[#E8E4DC] bg-white shadow-xl dark:border-emerald-950/40 dark:bg-[#12221b] {{ $panel === 'left' ? 'left-2' : 'right-2' }}"
    >
        <div class="border-b border-[#F1EDE6] bg-gradient-to-r from-[#FAF8F5] to-[#F5F0EA] px-4 py-3.5 dark:border-emerald-900/30 dark:bg-[#0e1b15]">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="flex size-6 items-center justify-center rounded-lg bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-300">
                        <flux:icon name="bell-alert" class="size-3.5" />
                    </span>
                    <div class="text-xs font-bold uppercase tracking-wider text-[#0D3326] dark:text-emerald-300">
                        {{ __('Low Stock Alerts') }}
                    </div>
                </div>
                @if($unreadCount > 0)
                    <span class="rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-bold text-rose-700 dark:bg-rose-950/60 dark:text-rose-300">{{ $unreadCount }}</span>
                @endif
            </div>
        </div>

        <div class="max-h-80 divide-y divide-[#F1EDE6] overflow-y-auto dark:divide-emerald-950/30">
            @forelse($notifications as $notification)
                @php($data = $notification->data)
                <a
                    href="{{ $data['url'] }}"
                    @click.prevent="$wire.markAsRead('{{ $notification->id }}').then(() => Livewire.navigate('{{ $data['url'] }}'))"
                    class="flex items-start gap-3 px-4 py-3 transition-colors hover:bg-[#FAF9F6] dark:hover:bg-emerald-950/30"
                >
                    <span class="mt-0.5 inline-flex size-8 shrink-0 items-center justify-center rounded-xl {{ $data['level'] === 'out_of_stock' ? 'bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400' : 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' }}">
                        <flux:icon name="{{ $data['level'] === 'out_of_stock' ? 'no-symbol' : 'exclamation-triangle' }}" class="size-4" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-2">
                            <div class="truncate text-sm font-semibold text-[#1A1A18] dark:text-stone-100">{{ $data['product_name'] }}</div>
                            <span class="shrink-0 text-xs text-stone-400 dark:text-emerald-300/50">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mt-0.5 text-xs text-stone-500 dark:text-emerald-300/60">
                            @if($data['level'] === 'out_of_stock')
                                <span class="font-semibold text-rose-600 dark:text-rose-400">{{ __('Out of stock') }}</span>
                            @else
                                <span class="font-semibold text-amber-600 dark:text-amber-400">{{ __('Low stock') }}</span>
                            @endif
                            · {{ $data['quantity'] }} {{ $data['unit'] }} / min {{ $data['min_stock'] }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="px-4 py-8 text-center">
                    <span class="mx-auto flex size-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-900/40 dark:text-emerald-300">
                        <flux:icon name="check-circle" class="size-6" />
                    </span>
                    <p class="mt-3 text-sm font-medium text-slate-600 dark:text-emerald-300/70">{{ __('You are all caught up.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>