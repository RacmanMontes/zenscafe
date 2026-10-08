<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search suppliers...') }}" icon="magnifying-glass" />
                </flux:field>
                @if(!$suppliers->isEmpty())
                    <div class="hidden lg:flex items-end text-sm text-stone-500 dark:text-emerald-300/60">
                        {{ $suppliers->total() }} {{ __('suppliers') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            @if($suppliers->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-cyan-50 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300">
                        <flux:icon name="truck" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No suppliers found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Get started by adding your first supplier.') }}</p>
                    <div class="mt-5">
                        <flux:button variant="primary" icon="plus" :href="route('suppliers.create')" wire:navigate class="rounded-xl">
                            {{ __('Add Supplier') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Name') }}</th>
                                <th class="cafe-th">{{ __('Contact') }}</th>
                                <th class="cafe-th">{{ __('Email') }}</th>
                                <th class="cafe-th">{{ __('Phone') }}</th>
                                <th class="cafe-th-right">{{ __('Products') }}</th>
                                <th class="cafe-th-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($suppliers as $index => $supplier)
                                <tr class="cafe-tr">
                                    <td class="cafe-td">
                                        <a href="{{ route('suppliers.show', $supplier) }}" wire:navigate class="group flex items-center gap-3">
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100 text-cyan-700 transition-colors group-hover:from-emerald-100 group-hover:to-teal-100 group-hover:text-emerald-700 dark:from-cyan-900/40 dark:to-sky-900/40 dark:text-cyan-300">
                                                <flux:icon name="building-storefront" class="size-5" />
                                            </span>
                                            <span class="font-semibold text-[#1A1A18] group-hover:text-cyan-700 dark:text-stone-100 dark:group-hover:text-cyan-300">{{ $supplier->name }}</span>
                                        </a>
                                    </td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $supplier->contact_person ?? '—' }}</td>
                                    <td class="cafe-td">
                                        @if($supplier->email)
                                            <a href="mailto:{{ $supplier->email }}" class="inline-flex items-center gap-1.5 text-stone-600 hover:text-cyan-700 dark:text-stone-300 dark:hover:text-cyan-300">
                                                <flux:icon name="envelope" class="size-3.5 text-stone-400 dark:text-emerald-300/50" />
                                                <span class="truncate max-w-[160px]">{{ $supplier->email }}</span>
                                            </a>
                                        @else
                                            <span class="text-stone-400 dark:text-emerald-300/40">—</span>
                                        @endif
                                    </td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $supplier->phone ?? '—' }}</td>
                                    <td class="cafe-td-right">
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#EFEAE3] bg-[#FAF8F5] px-2.5 py-0.5 text-xs font-semibold text-stone-700 dark:border-emerald-900/30 dark:bg-emerald-950/40 dark:text-emerald-300">
                                            <flux:icon name="cube" class="size-3 text-cyan-600 dark:text-cyan-400" />
                                            {{ $supplier->products_count }}
                                        </span>
                                    </td>
                                    <td class="cafe-td-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <flux:button variant="subtle" size="sm" icon="eye" :href="route('suppliers.show', $supplier)" wire:navigate class="rounded-lg" title="{{ __('View') }}" aria-label="{{ __('View') }}">
                                                {{ __('View') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('suppliers.edit', $supplier)" wire:navigate class="rounded-lg" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="trash" @click="$wire.confirmArchive({{ $supplier->id }})" class="rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-950/40" title="{{ __('Archive') }}" aria-label="{{ __('Archive') }}">
                                                {{ __('Archive') }}
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-t border-[#F1EDE6] px-4 py-4 dark:border-emerald-950/30">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>

    <flux:modal wire:model="showArchiveModal" class="rounded-2xl p-6">
        <div class="flex items-start gap-3">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400">
                <flux:icon name="archive-box" class="size-5" />
            </span>
            <div>
                <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Archive Supplier') }}</h3>
                <p class="mt-1.5 text-sm text-stone-500 dark:text-emerald-300/60">
                    {{ __('Are you sure you want to archive this supplier?') }}
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

    <div
        wire:ignore
        x-data="floatingActionButton()"
        x-cloak
        class="pointer-events-none fixed inset-0 z-40"
    >
        <div
            class="pointer-events-auto absolute bottom-6 right-6"
            :style="style"
            @mousedown="onMouseDown($event)"
            @touchstart="onTouchStart($event)"
            @click="onClick($event)"
        >
            <a
                href="{{ route('suppliers.create') }}"
                wire:navigate
                title="{{ __('Add Supplier') }}"
                aria-label="{{ __('Add Supplier') }}"
                class="group flex h-10 min-w-10 cursor-grab select-none items-center justify-center overflow-hidden rounded-full bg-emerald-700 text-white no-underline shadow-lg shadow-emerald-900/25 transition-all duration-300 ease-out hover:justify-start hover:pl-4 hover:pr-5 hover:bg-emerald-800 active:cursor-grabbing dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
            >
                <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span class="max-w-0 overflow-hidden whitespace-nowrap text-sm font-semibold opacity-0 transition-all duration-300 ease-out group-hover:ml-2 group-hover:max-w-40 group-hover:opacity-100">{{ __('Add Supplier') }}</span>
            </a>
        </div>
    </div>
</div>