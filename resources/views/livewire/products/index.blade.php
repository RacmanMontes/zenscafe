<div>
    <div class="flex flex-col gap-6">
        <!-- Filters -->
        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search by name or SKU...') }}" icon="magnifying-glass" />
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="categoryFilter">
                        <flux:select.option value="">{{ __('All Categories') }}</flux:select.option>
                        @foreach($categories as $category)
                            <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="supplierFilter">
                        <flux:select.option value="">{{ __('All Suppliers') }}</flux:select.option>
                        @foreach($suppliers as $supplier)
                            <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="statusFilter">
                        <flux:select.option value="">{{ __('All Status') }}</flux:select.option>
                        <flux:select.option value="active">{{ __('Active') }}</flux:select.option>
                        <flux:select.option value="archived">{{ __('Archived') }}</flux:select.option>
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:select wire:model.live="stockFilter">
                        <flux:select.option value="">{{ __('All Stock Levels') }}</flux:select.option>
                        <flux:select.option value="in_stock">{{ __('In Stock') }}</flux:select.option>
                        <flux:select.option value="low_stock">{{ __('Low Stock') }}</flux:select.option>
                        <flux:select.option value="out_of_stock">{{ __('Out of Stock') }}</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
        </div>

        <!-- Products Table -->
        <div class="cafe-card overflow-hidden p-0">
            @if($products->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                        <flux:icon name="cube" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No products found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Get started by adding your first product.') }}</p>
                    <div class="mt-5">
                        <flux:button variant="primary" icon="plus" @click="$wire.openCreateModal()" class="rounded-xl">
                            {{ __('Add Product') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Item') }}</th>
                                <th class="cafe-th">{{ __('SKU') }}</th>
                                <th class="cafe-th">{{ __('Category') }}</th>
                                <th class="cafe-th">{{ __('Supplier') }}</th>
                                <th class="cafe-th-right">{{ __('Qty') }}</th>
                                <th class="cafe-th">{{ __('Status') }}</th>
                                <th class="cafe-th-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($products as $product)
                                <tr class="cafe-tr">
                                    <td class="cafe-td">
                                        <a href="{{ route('products.show', $product) }}" wire:navigate class="group flex items-center gap-3">
                                            <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-[#F2EFEA] text-stone-500 transition-colors group-hover:bg-emerald-100 group-hover:text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-300">
                                                <flux:icon name="cube" class="size-4.5" />
                                            </span>
                                            <div class="min-w-0">
                                                <div class="font-semibold text-[#1A1A18] group-hover:text-emerald-800 dark:text-stone-100 dark:group-hover:text-emerald-300">{{ $product->name }}</div>
                                                @if($product->description)
                                                    <div class="truncate text-xs text-stone-500 max-w-[220px] dark:text-emerald-300/60">{{ $product->description }}</div>
                                                @endif
                                            </div>
                                        </a>
                                    </td>
                                    <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</td>
                                    <td class="cafe-td">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-2.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                            {{ $product->category->name ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $product->supplier->name ?? '—' }}</td>
                                    <td class="cafe-td-right">
                                        <span class="font-semibold text-stone-800 dark:text-stone-100">{{ $product->quantity }}</span>
                                        <span class="text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->unitLabel() }}</span>
                                    </td>
                                    <td class="cafe-td">
                                        @if($product->status === 'archived')
                                            <span class="cafe-status-pill border-stone-200 bg-stone-100 text-stone-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                <span class="cafe-status-pill-dot bg-stone-400"></span>
                                                {{ __('Archived') }}
                                            </span>
                                        @elseif($product->isOutOfStock())
                                            <span class="cafe-status-pill border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300">
                                                <span class="cafe-status-pill-dot bg-rose-500"></span>
                                                {{ __('Out of Stock') }}
                                            </span>
                                        @elseif($product->isLowStock())
                                            <span class="cafe-status-pill border-amber-200/80 bg-amber-50 text-amber-700 dark:border-amber-800/40 dark:bg-amber-950/70 dark:text-amber-300">
                                                <span class="cafe-status-pill-dot bg-amber-500"></span>
                                                {{ __('Low Stock') }}
                                            </span>
                                        @else
                                            <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                                                <span class="cafe-status-pill-dot bg-emerald-500"></span>
                                                {{ __('In Stock') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="cafe-td-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <flux:button variant="subtle" size="sm" icon="eye" :href="route('products.show', $product)" wire:navigate class="rounded-lg" title="{{ __('View') }}" aria-label="{{ __('View') }}">
                                                {{ __('View') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="pencil" @click="$wire.openEditModal({{ $product->id }})" class="rounded-lg" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-t border-[#F1EDE6] px-4 py-4 dark:border-emerald-950/30">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Create Product Modal -->
    <flux:modal wire:model.self="showCreateModal" class="rounded-2xl p-6 w-full sm:max-w-3xl">
        @if($showCreateModal)
            <livewire:products.create :key="'product-create-form'" />
        @endif
    </flux:modal>

    <!-- Edit Product Modal -->
    <flux:modal wire:model.self="showEditModal" class="rounded-2xl p-6 w-full sm:max-w-3xl">
        @if($showEditModal && $editingProduct)
            <livewire:products.edit :product="$editingProduct" :key="'product-edit-form-'.$editingProduct->id" />
        @endif
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
                href="#"
                @click.prevent="$wire.openCreateModal()"
                title="{{ __('Add Product') }}"
                aria-label="{{ __('Add Product') }}"
                class="group flex h-10 min-w-10 cursor-grab select-none items-center justify-center overflow-hidden rounded-full bg-emerald-700 text-white no-underline shadow-lg shadow-emerald-900/25 transition-all duration-300 ease-out hover:justify-start hover:pl-4 hover:pr-5 hover:bg-emerald-800 active:cursor-grabbing dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
            >
                <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span class="max-w-0 overflow-hidden whitespace-nowrap text-sm font-semibold opacity-0 transition-all duration-300 ease-out group-hover:ml-2 group-hover:max-w-40 group-hover:opacity-100">{{ __('Add Product') }}</span>
            </a>
        </div>
    </div>
</div>