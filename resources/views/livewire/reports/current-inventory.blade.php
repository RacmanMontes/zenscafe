<div>
    <style>
        @media print {
            @page {
                size: A4 landscape;
                margin: 12mm;
            }

            body {
                background: #fff !important;
            }

            [data-flux-sidebar],
            [data-flux-header] {
                display: none !important;
            }

            [data-flux-main] {
                padding: 0 !important;
            }

            .report-print-hidden {
                display: none !important;
            }

            .report-print-only {
                display: block !important;
            }

            .report-print-table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .report-print-table th,
            .report-print-table td {
                border: 1px solid #d6d3d1 !important;
                padding: 4px 6px !important;
                font-size: 9.5px !important;
                text-align: left !important;
                vertical-align: top !important;
            }

            .report-print-table thead th {
                background: #f5f5f4 !important;
                text-transform: uppercase !important;
                font-size: 9px !important;
            }

            .report-print-table th.text-right,
            .report-print-table td.text-right {
                text-align: right !important;
            }

            .report-print-title {
                margin: 0 0 2px;
                font-size: 15px;
                font-weight: 700;
                text-transform: uppercase;
            }

            .report-print-meta {
                margin: 0 0 10px;
                padding-bottom: 6px;
                border-bottom: 2px solid #1c1917;
                font-size: 9.5px;
                color: #57534e;
            }

            .report-print-summary {
                margin: 0 0 12px;
                font-size: 10.5px;
            }

            .report-print-summary span {
                margin-inline-end: 16px;
                font-weight: 700;
            }

            .report-print-footer {
                margin-top: 12px;
                padding-top: 6px;
                border-top: 1px solid #d6d3d1;
                font-size: 9px;
                color: #78716c;
            }
        }
    </style>

    <div class="flex flex-col gap-6">
        <div class="report-print-only hidden">
            <div class="report-print-title">Zen's Cafe - Current Inventory Report</div>
            <div class="report-print-meta">
                Generated on {{ now()->format('F d, Y \a\t g:i A') }}
            </div>
            <div class="report-print-summary">
                <span>{{ __('Total Items') }}: {{ $totalItems }}</span>
                <span>{{ __('Total Quantity') }}: {{ $totalQuantity }}</span>
                <span>{{ __('Total Value') }}: ${{ number_format($totalValue, 2) }}</span>
            </div>
        </div>

        <div class="report-print-hidden cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('reports')" wire:navigate class="rounded-lg">
                        {{ __('Reports') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Current Inventory') }}</span>
                </div>
                <div class="flex items-center gap-2.5 mt-2">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-sky-500 to-blue-600 text-white shadow-xs">
                        <flux:icon name="cube" class="size-5" />
                    </span>
                    <h1 class="cafe-page-title">{{ __('Current Inventory Report') }}</h1>
                </div>
                <p class="cafe-page-subtitle">{{ now()->format('F d, Y \a\t g:i A') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <flux:dropdown>
                    <flux:button variant="primary" icon="arrow-down-tray" class="rounded-xl">{{ __('Download') }}</flux:button>
                    <flux:menu>
                        <flux:menu.item icon="document-arrow-down" :href="route('reports.current-inventory.export-pdf', ['search' => $search, 'category_id' => $category_id, 'supplier_id' => $supplier_id])">
                            {{ __('PDF') }}
                        </flux:menu.item>
                        <flux:menu.item icon="document-chart-bar" :href="route('reports.current-inventory.export-excel', ['search' => $search, 'category_id' => $category_id, 'supplier_id' => $supplier_id])">
                            {{ __('Excel') }}
                        </flux:menu.item>
                        <flux:menu.item icon="document-text" :href="route('reports.current-inventory.export-word', ['search' => $search, 'category_id' => $category_id, 'supplier_id' => $supplier_id])">
                            {{ __('Word') }}
                        </flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
                <flux:button variant="subtle" icon="printer" @click="window.print()" class="rounded-xl">
                    {{ __('Print') }}
                </flux:button>
            </div>
        </div>

        <div class="report-print-hidden grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-[#D8EDE3] bg-gradient-to-br from-[#EEF8F3] to-[#E3F4EB] p-5 shadow-sm dark:border-emerald-900/40 dark:from-[#132C22] dark:to-[#0D221A]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-xs">
                        <flux:icon name="cube" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-800/80 dark:text-emerald-300/80">{{ __('Total Items') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-50">{{ $totalItems }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-[#D6E8F5] bg-gradient-to-br from-[#F0F8FF] to-[#E3F1FA] p-5 shadow-sm dark:border-sky-900/40 dark:from-[#13252E] dark:to-[#0D1D23]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sky-500 text-white shadow-xs">
                        <flux:icon name="square-2-stack" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-sky-800/80 dark:text-sky-300/80">{{ __('Total Quantity') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-sky-950 dark:text-sky-50">{{ $totalQuantity }}</div>
                    </div>
                </div>
            </div>
            <div class="rounded-2xl border border-[#F3E3BA] bg-gradient-to-br from-[#FEF9ED] to-[#FDF2D7] p-5 shadow-sm dark:border-amber-900/40 dark:from-[#2A2212] dark:to-[#1F190D]">
                <div class="flex items-center gap-3">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-xs">
                        <flux:icon name="banknotes" class="size-5" />
                    </span>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-amber-800/80 dark:text-amber-300/80">{{ __('Total Value') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-amber-950 dark:text-amber-50">${{ number_format($totalValue, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            <div class="report-print-hidden p-5 border-b border-[#F1EDE6] dark:border-emerald-950/30">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <flux:field>
                        <flux:input wire:model.live="search" placeholder="{{ __('Search...') }}" icon="magnifying-glass" />
                    </flux:field>
                    <flux:field>
                        <flux:select wire:model.live="category_id">
                            <flux:select.option value="">{{ __('All Categories') }}</flux:select.option>
                            @foreach($categories as $category)
                                <flux:select.option value="{{ $category->id }}">{{ $category->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                    <flux:field>
                        <flux:select wire:model.live="supplier_id">
                            <flux:select.option value="">{{ __('All Suppliers') }}</flux:select.option>
                            @foreach($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->id }}">{{ $supplier->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </flux:field>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="report-print-table w-full text-sm">
                    <thead>
                        <tr class="cafe-thead-row">
                            <th class="cafe-th">{{ __('Item') }}</th>
                            <th class="cafe-th">{{ __('SKU') }}</th>
                            <th class="cafe-th">{{ __('Category') }}</th>
                            <th class="cafe-th">{{ __('Supplier') }}</th>
                            <th class="cafe-th-right">{{ __('Qty') }}</th>
                            <th class="cafe-th-right">{{ __('Min') }}</th>
                            <th class="cafe-th-right">{{ __('Unit Cost') }}</th>
                            <th class="cafe-th-right">{{ __('Value') }}</th>
                            <th class="cafe-th">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody class="cafe-tbody">
                        @forelse($products as $product)
                            <tr class="cafe-tr">
                                <td class="cafe-td font-semibold text-stone-800 dark:text-stone-100">{{ $product->name }}</td>
                                <td class="cafe-td font-mono text-xs text-stone-500 dark:text-emerald-300/60">{{ $product->sku }}</td>
                                <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $product->category->name ?? '—' }}</td>
                                <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $product->supplier->name ?? '—' }}</td>
                                <td class="cafe-td-right font-semibold text-stone-800 dark:text-stone-100">{{ $product->quantity }} <span class="text-xs font-normal text-stone-500 dark:text-emerald-300/60">{{ $product->unit }}</span></td>
                                <td class="cafe-td-right text-stone-500 dark:text-emerald-300/60">{{ $product->min_stock }}</td>
                                <td class="cafe-td-right text-stone-600 dark:text-stone-300">{{ $product->cost_per_unit !== null ? '$' . number_format($product->cost_per_unit, 2) : '—' }}</td>
                                <td class="cafe-td-right font-medium text-stone-800 dark:text-stone-100">{{ $product->cost_per_unit !== null ? '$' . number_format($product->quantity * $product->cost_per_unit, 2) : '—' }}</td>
                                <td class="cafe-td">
                                    @if($product->isOutOfStock())
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-8 text-center text-zinc-500 dark:text-emerald-300/60">{{ __('No products found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-print-only report-print-footer hidden">
            Prepared by ZEN'S CAFE Web-Based Inventory Management System.
        </div>
    </div>
</div>