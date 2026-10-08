<div>
    <div class="flex flex-col gap-6">
        <!-- Filters -->
        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search categories...') }}" icon="magnifying-glass" />
                </flux:field>
                @if(!$categories->isEmpty())
                    <div class="hidden lg:flex items-end text-sm text-stone-500 dark:text-emerald-300/60">
                        {{ $categories->total() }} {{ __('categories') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Categories Table -->
        <div class="cafe-card overflow-hidden p-0">
            @if($categories->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                        <flux:icon name="folder" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No categories found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Get started by adding your first category.') }}</p>
                    <div class="mt-5">
                        <flux:button variant="primary" icon="plus" :href="route('categories.create')" wire:navigate class="rounded-xl">
                            {{ __('Add Category') }}
                        </flux:button>
                    </div>
                </div>
            @else
                @php
                    $accentMap = ['Coffee Beans' => 'indigo', 'Tea' => 'purple', 'Milk & Cream' => 'cyan', 'Syrups & Flavors' => 'amber', 'Pastries' => 'rose', 'Supplies' => 'emerald'];
                    $fallbackAccents = ['indigo', 'purple', 'cyan', 'amber', 'rose', 'emerald', 'sky', 'fuchsia', 'teal'];
                @endphp
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Name') }}</th>
                                <th class="cafe-th">{{ __('Description') }}</th>
                                <th class="cafe-th-right">{{ __('Products') }}</th>
                                <th class="cafe-th-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($categories as $index => $category)
                                @php
                                    $accent = $accentMap[$category->name] ?? $fallbackAccents[$index % count($fallbackAccents)];
                                    $dot = ['indigo' => 'bg-indigo-500', 'purple' => 'bg-purple-500', 'cyan' => 'bg-cyan-500', 'amber' => 'bg-amber-500', 'rose' => 'bg-rose-500', 'emerald' => 'bg-emerald-500', 'sky' => 'bg-sky-500', 'fuchsia' => 'bg-fuchsia-500', 'teal' => 'bg-teal-500'][$accent];
                                    $chip = ['indigo' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300', 'purple' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300', 'cyan' => 'bg-cyan-50 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300', 'amber' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300', 'rose' => 'bg-rose-50 text-rose-700 dark:bg-rose-900/40 dark:text-rose-300', 'emerald' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300', 'sky' => 'bg-sky-50 text-sky-700 dark:bg-sky-900/40 dark:text-sky-300', 'fuchsia' => 'bg-fuchsia-50 text-fuchsia-700 dark:bg-fuchsia-900/40 dark:text-fuchsia-300', 'teal' => 'bg-teal-50 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300'][$accent];
                                    $icon = ['Coffee Beans' => 'fire', 'Tea' => 'beaker', 'Milk & Cream' => 'circle-stack', 'Syrups & Flavors' => 'sparkles', 'Pastries' => 'cake', 'Supplies' => 'truck', 'Equipment' => 'wrench'];
                                @endphp
                                <tr class="cafe-tr">
                                    <td class="cafe-td">
                                        <div class="flex items-center gap-3">
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl {{ $chip }}">
                                                <flux:icon name="{{ $icon[$category->name] ?? 'folder' }}" class="size-5" />
                                            </span>
                                            <span class="font-semibold text-[#1A1A18] dark:text-stone-100">{{ $category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="cafe-td text-stone-500 dark:text-emerald-300/60">{{ $category->description ?? '—' }}</td>
                                    <td class="cafe-td-right">
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#EFEAE3] bg-[#FAF8F5] px-2.5 py-0.5 text-xs font-semibold text-stone-700 dark:border-emerald-900/30 dark:bg-emerald-950/40 dark:text-emerald-300">
                                            <span class="size-1.5 rounded-full {{ $dot }}"></span>
                                            {{ $category->products_count }} {{ __('items') }}
                                        </span>
                                    </td>
                                    <td class="cafe-td-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('categories.edit', $category)" wire:navigate class="rounded-lg" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="trash" @click="$wire.confirmArchive({{ $category->id }})" class="rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-950/40" title="{{ __('Archive') }}" aria-label="{{ __('Archive') }}">
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
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Archive Modal -->
    <flux:modal wire:model="showArchiveModal" class="rounded-2xl p-6">
        <div class="flex items-start gap-3">
            <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-rose-50 text-rose-600 dark:bg-rose-950/40 dark:text-rose-400">
                <flux:icon name="archive-box" class="size-5" />
            </span>
            <div>
                <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Archive Category') }}</h3>
                <p class="mt-1.5 text-sm text-stone-500 dark:text-emerald-300/60">
                    {{ __('Are you sure you want to archive this category?') }}
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
                href="{{ route('categories.create') }}"
                wire:navigate
                title="{{ __('Add Category') }}"
                aria-label="{{ __('Add Category') }}"
                class="group flex h-10 min-w-10 cursor-grab select-none items-center justify-center overflow-hidden rounded-full bg-emerald-700 text-white no-underline shadow-lg shadow-emerald-900/25 transition-all duration-300 ease-out hover:justify-start hover:pl-4 hover:pr-5 hover:bg-emerald-800 active:cursor-grabbing dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
            >
                <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span class="max-w-0 overflow-hidden whitespace-nowrap text-sm font-semibold opacity-0 transition-all duration-300 ease-out group-hover:ml-2 group-hover:max-w-40 group-hover:opacity-100">{{ __('Add Category') }}</span>
            </a>
        </div>
    </div>
</div>