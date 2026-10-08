<div wire:poll.30s>
    <div class="flex h-full w-full flex-1 flex-col gap-6">

        <!-- Café Hero Welcome Banner -->
        <div class="relative overflow-hidden rounded-2xl border border-[#EBDDCB] bg-gradient-to-r from-[#FAF6F0] via-[#FCF9F5] to-[#F5EFEB] p-6 shadow-[0_2px_12px_rgba(180,140,100,0.06)] dark:border-emerald-900/30 dark:from-[#152920] dark:via-[#11231b] dark:to-[#0d1c16] sm:p-7">
            <!-- Subtle botanical leaf background decorations -->
            <div class="pointer-events-none absolute -right-6 -top-8 size-48 select-none opacity-[0.12] dark:opacity-[0.06]">
                <svg viewBox="0 0 200 200" fill="none" class="size-full text-emerald-800 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 20C100 20 125 65 170 80C125 95 100 140 100 140C100 140 75 95 30 80C75 65 100 20 100 20Z" fill="currentColor"/>
                    <path d="M140 70C140 70 155 100 185 110C155 120 140 150 140 150C140 150 125 120 95 110C125 100 140 70 140 70Z" fill="currentColor"/>
                </svg>
            </div>

            <div class="pointer-events-none absolute -bottom-10 right-40 size-40 select-none opacity-[0.09] dark:opacity-[0.05]">
                <svg viewBox="0 0 100 100" fill="none" class="size-full text-amber-900 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg">
                    <!-- Coffee bean graphic -->
                    <path d="M50 10C27.9 10 10 27.9 10 50C10 72.1 27.9 90 50 90C72.1 90 90 72.1 90 50C90 27.9 72.1 10 50 10ZM50 82C32.3 82 18 67.7 18 50C18 32.3 32.3 18 50 18C67.7 18 82 32.3 82 50C82 67.7 67.7 82 50 82Z" fill="currentColor"/>
                    <path d="M46 22C46 22 56 36 46 50C36 64 46 78 46 78" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>

            <div class="pointer-events-none absolute -left-12 -bottom-12 size-44 rounded-full bg-emerald-400/10 blur-2xl select-none"></div>
            <div class="pointer-events-none absolute right-10 top-0 size-36 rounded-full bg-amber-300/15 blur-2xl select-none"></div>

            <div class="relative z-10 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-200/80 bg-emerald-100/70 px-3 py-1 text-xs font-semibold text-emerald-900 shadow-2xs dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300 mb-2.5">
                        <svg class="size-3.5 text-emerald-700 dark:text-emerald-400" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/>
                        </svg>
                        <span>Zen's Café Inventory System</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#0D3326] dark:text-emerald-100">
                        {{ __('Dashboard') }}
                    </h1>
                    <p class="mt-1 text-sm sm:text-base font-medium text-[#4A6B5D] dark:text-emerald-300/80">
                        {{ __('Welcome to Zen\'s Cafe Inventory Management System') }}
                    </p>
                </div>

                <div x-data="{ now: new Date() }" x-init="setInterval(() => now = new Date(), 1000)" class="relative z-10 flex flex-col sm:items-end justify-center rounded-2xl border border-[#E8DFD5]/90 bg-white/85 px-5 py-3.5 shadow-2xs backdrop-blur-md dark:border-emerald-900/40 dark:bg-[#10241C]/85">
                    <div class="text-base font-bold text-[#144233] dark:text-emerald-100" x-text="now.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></div>
                    <div class="mt-1 flex items-center gap-2 text-xs font-semibold text-[#5C7569] dark:text-emerald-300/70">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-emerald-500"></span>
                        </span>
                        <span x-text="now.toLocaleTimeString()"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6 KPI Summary Cards (Soft pastel backgrounds & colored icon containers) -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

            <!-- 1. Total Items (Green / Mint) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#C5E8D5] bg-gradient-to-br from-[#EEF8F3] to-[#E3F4EB] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-emerald-900/40 dark:from-[#132C22] dark:to-[#0D221A]">
                <!-- Subtle leaf pattern watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-emerald-600/10 select-none transition-transform group-hover:scale-110 dark:text-emerald-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.5 2 2 6.5 2 12c0 3.5 1.8 6.6 4.6 8.4l.4-.4c3.5-3.5 5.5-8.2 5.5-13.2 0-.9-.1-1.9-.3-2.8H12zm1.2 0c.2.9.3 1.9.3 2.8 0 5 2 9.7 5.5 13.2l.4.4C22.2 18.6 24 15.5 24 12c0-5.5-4.5-10-10-10h-.8z"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-emerald-500 dark:text-emerald-950">
                        <flux:icon name="cube" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-emerald-800/80 dark:text-emerald-300/80">{{ __('Total Items') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-emerald-950 dark:text-emerald-50">{{ number_format($totalProducts) }}</div>
                    </div>
                </div>
            </div>

            <!-- 2. Categories (Yellow / Cream) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#F6E3B8] bg-gradient-to-br from-[#FEF9ED] to-[#FDF2D7] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-amber-900/40 dark:from-[#2A2212] dark:to-[#1F190D]">
                <!-- Subtle coffee bean watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-amber-600/10 select-none transition-transform group-hover:scale-110 dark:text-amber-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    <path d="M11 6c0 3 2 6 2 6s2 3 2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-amber-400 dark:text-amber-950">
                        <flux:icon name="folder" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-amber-800/80 dark:text-amber-300/80">{{ __('Categories') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-amber-950 dark:text-amber-50">{{ number_format($totalCategories) }}</div>
                    </div>
                </div>
            </div>

            <!-- 3. Suppliers (Light Blue / Cyan) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#C7E5EE] bg-gradient-to-br from-[#F0F9FB] to-[#E0F3F7] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-cyan-900/40 dark:from-[#13272E] dark:to-[#0D1D23]">
                <!-- Subtle delivery watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-cyan-600/10 select-none transition-transform group-hover:scale-110 dark:text-cyan-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                    <path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-cyan-600 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-cyan-400 dark:text-cyan-950">
                        <flux:icon name="truck" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-cyan-800/80 dark:text-cyan-300/80">{{ __('Suppliers') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-cyan-950 dark:text-cyan-50">{{ number_format($totalSuppliers) }}</div>
                    </div>
                </div>
            </div>

            <!-- 4. Low Stock (Orange / Peach) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#FFD7BA] bg-gradient-to-br from-[#FFF5ED] to-[#FFE8D6] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-orange-900/40 dark:from-[#2E1D13] dark:to-[#21140C]">
                <!-- Subtle warning watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-orange-600/10 select-none transition-transform group-hover:scale-110 dark:text-orange-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L1 21h22L12 2zm0 3.5L20 19H4L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z" opacity="0.3"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-orange-400 dark:text-orange-950">
                        <flux:icon name="exclamation-triangle" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-orange-800/80 dark:text-orange-300/80">{{ __('Low Stock') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-orange-950 dark:text-orange-50">{{ number_format($lowStockCount) }}</div>
                    </div>
                </div>
            </div>

            <!-- 5. Out of Stock (Pink / Red) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#FFC7D0] bg-gradient-to-br from-[#FFF0F3] to-[#FFE0E6] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-rose-900/40 dark:from-[#2E141A] dark:to-[#210E12]">
                <!-- Subtle prohibited watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-rose-600/10 select-none transition-transform group-hover:scale-110 dark:text-rose-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8 0-1.85.63-3.55 1.69-4.9L16.9 18.31C15.55 19.37 13.85 20 12 20zm6.31-3.1L7.1 5.69C8.45 4.63 10.15 4 12 4c4.42 0 8 3.58 8 8 0 1.85-.63 3.55-1.69 4.9z" opacity="0.3"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-rose-600 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-rose-400 dark:text-rose-950">
                        <flux:icon name="no-symbol" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-rose-800/80 dark:text-rose-300/80">{{ __('Out of Stock') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-rose-950 dark:text-rose-50">{{ number_format($outOfStockCount) }}</div>
                    </div>
                </div>
            </div>

            <!-- 6. Users (Lavender / Purple) -->
            <div class="group relative overflow-hidden rounded-2xl border border-[#DDD1F4] bg-gradient-to-br from-[#F5F2FC] to-[#ECE3FA] p-5 shadow-xs transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md dark:border-purple-900/40 dark:from-[#21172F] dark:to-[#181023]">
                <!-- Subtle users watermark -->
                <svg class="pointer-events-none absolute -bottom-3 -right-3 size-20 text-purple-600/10 select-none transition-transform group-hover:scale-110 dark:text-purple-400/5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" opacity="0.3"/>
                </svg>
                <div class="relative z-10 flex items-center gap-3.5">
                    <div class="flex size-12 shrink-0 items-center justify-center rounded-xl bg-purple-600 text-white shadow-xs transition-transform group-hover:scale-105 dark:bg-purple-400 dark:text-purple-950">
                        <flux:icon name="users" class="size-6" />
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[11px] font-bold uppercase tracking-wider text-purple-800/80 dark:text-purple-300/80">{{ __('Users') }}</div>
                        <div class="mt-0.5 text-2xl font-extrabold tracking-tight text-purple-950 dark:text-purple-50">{{ number_format($totalUsers) }}</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Stock Movements (Last 7 Days) Chart -->
            <div class="rounded-2xl border border-[#E8E4DC] bg-white p-6 shadow-xs transition-shadow hover:shadow-md dark:border-emerald-950/40 dark:bg-[#12221B]">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                            <flux:icon name="chart-bar" class="size-5" />
                        </span>
                        <div>
                            <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Stock Movements (Last 7 Days)') }}</h3>
                            <p class="text-xs text-stone-500 dark:text-emerald-300/70">{{ __('Daily incoming and outgoing inventory') }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/70 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800 dark:border-emerald-800/40 dark:bg-emerald-950/50 dark:text-emerald-300">
                        <span class="size-1.5 rounded-full bg-emerald-500"></span>
                        {{ __('7 Days') }}
                    </span>
                </div>

                <div wire:ignore x-data="{ chart: null }" x-init="
                    const isDark = document.documentElement.classList.contains('dark');
                    const options = {
                        chart: {
                            type: 'bar',
                            height: 310,
                            toolbar: { show: false },
                            fontFamily: '\'Instrument Sans\', ui-sans-serif, system-ui, sans-serif',
                            parentHeightOffset: 0,
                        },
                        series: [
                            { name: 'Stock In', data: {{ $stockMovements->pluck('stock_in_total')->toJson() }} },
                            { name: 'Stock Out', data: {{ $stockMovements->pluck('stock_out_total')->toJson() }} }
                        ],
                        xaxis: {
                            categories: {{ $stockMovements->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))->toJson() }},
                            axisBorder: { show: false },
                            axisTicks: { show: false },
                            labels: {
                                style: {
                                    colors: '#78716c',
                                    fontSize: '12px',
                                    fontWeight: 500,
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                style: {
                                    colors: '#78716c',
                                    fontSize: '12px',
                                    fontWeight: 500,
                                }
                            }
                        },
                        grid: {
                            borderColor: 'rgba(120, 113, 108, 0.12)',
                            strokeDashArray: 4,
                            padding: { top: 0, right: 10, bottom: 0, left: 10 }
                        },
                        colors: ['#10B981', '#F43F5E'],
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                borderRadiusApplication: 'end',
                                columnWidth: '46%',
                            }
                        },
                        dataLabels: { enabled: false },
                        legend: {
                            position: 'bottom',
                            fontFamily: '\'Instrument Sans\', sans-serif',
                            fontWeight: 600,
                            markers: {
                                radius: 12,
                                width: 10,
                                height: 10,
                            },
                            itemMargin: { horizontal: 14, vertical: 6 }
                        },
                        tooltip: {
                            theme: isDark ? 'dark' : 'light',
                            style: {
                                fontSize: '12px',
                                fontFamily: '\'Instrument Sans\', sans-serif'
                            }
                        }
                    };
                    chart = new ApexCharts($el, options);
                    chart.render();
                "></div>
            </div>

            <!-- Items by Category Donut Chart -->
            @php
                $categoryColorsMap = [
                    'Coffee Beans' => '#4F46E5',    // blue/indigo
                    'Tea' => '#8B5CF6',             // purple
                    'Milk & Cream' => '#06B6D4',    // cyan
                    'Syrups & Flavors' => '#F59E0B',// amber/orange
                    'Pastries' => '#F43F5E',        // red/pink
                    'Supplies' => '#10B981',        // green
                    'Equipment' => '#0EA5E9',       // sky blue
                ];
                $fallbackPalette = ['#4F46E5', '#8B5CF6', '#06B6D4', '#F59E0B', '#F43F5E', '#10B981', '#0EA5E9', '#EC4899', '#14B8A6'];
                $mappedCategoryColors = $categoryDistribution->map(function ($item, $index) use ($categoryColorsMap, $fallbackPalette) {
                    $name = $item->category->name ?? 'Uncategorized';
                    return $categoryColorsMap[$name] ?? $fallbackPalette[$index % count($fallbackPalette)];
                })->values();
            @endphp

            <div class="rounded-2xl border border-[#E8E4DC] bg-white p-6 shadow-xs transition-shadow hover:shadow-md dark:border-emerald-950/40 dark:bg-[#12221B]">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <span class="flex size-9 items-center justify-center rounded-xl bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300">
                            <flux:icon name="folder" class="size-5" />
                        </span>
                        <div>
                            <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Items by Category') }}</h3>
                            <p class="text-xs text-stone-500 dark:text-emerald-300/70">{{ __('Product distribution across café categories') }}</p>
                        </div>
                    </div>
                    <span class="rounded-full border border-stone-200/80 bg-stone-50 px-2.5 py-1 text-xs font-semibold text-stone-700 dark:border-emerald-800/40 dark:bg-emerald-950/50 dark:text-emerald-300">
                        {{ $categoryDistribution->count() }} {{ __('Categories') }}
                    </span>
                </div>

                <div wire:ignore x-data="{ chart: null }" x-init="
                    const isDark = document.documentElement.classList.contains('dark');
                    const options = {
                        chart: {
                            type: 'donut',
                            height: 310,
                            fontFamily: '\'Instrument Sans\', ui-sans-serif, system-ui, sans-serif',
                        },
                        series: {{ $categoryDistribution->pluck('count')->toJson() }},
                        labels: {{ $categoryDistribution->pluck('category.name')->map(fn($n) => $n ?? 'Uncategorized')->toJson() }},
                        colors: {{ $mappedCategoryColors->toJson() }},
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '72%',
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontSize: '13px',
                                            fontFamily: '\'Instrument Sans\', sans-serif',
                                            fontWeight: 600,
                                            color: '#78716c',
                                            offsetY: -4,
                                        },
                                        value: {
                                            show: true,
                                            fontSize: '22px',
                                            fontFamily: '\'Instrument Sans\', sans-serif',
                                            fontWeight: 800,
                                            color: isDark ? '#ecfdf5' : '#0d3326',
                                            offsetY: 6,
                                            formatter: function(val) { return val; }
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total Items',
                                            fontSize: '12px',
                                            fontFamily: '\'Instrument Sans\', sans-serif',
                                            fontWeight: 600,
                                            color: '#78716c',
                                            formatter: function (w) {
                                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        stroke: {
                            width: 2,
                            colors: [isDark ? '#12221b' : '#ffffff']
                        },
                        legend: {
                            position: 'bottom',
                            fontFamily: '\'Instrument Sans\', sans-serif',
                            fontWeight: 500,
                            markers: {
                                radius: 12,
                                width: 10,
                                height: 10,
                            },
                            itemMargin: { horizontal: 10, vertical: 6 }
                        },
                        dataLabels: { enabled: false },
                        tooltip: {
                            theme: isDark ? 'dark' : 'light',
                            style: {
                                fontSize: '12px',
                                fontFamily: '\'Instrument Sans\', sans-serif'
                            }
                        }
                    };
                    chart = new ApexCharts($el, options);
                    chart.render();
                "></div>
            </div>

        </div>

        <!-- Recent Transactions Table Card -->
        <div class="rounded-2xl border border-[#E8E4DC] bg-white p-6 shadow-xs transition-shadow hover:shadow-md dark:border-emerald-950/40 dark:bg-[#12221B]">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                        <flux:icon name="clock" class="size-5" />
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Recent Transactions') }}</h3>
                        <p class="text-xs text-stone-500 dark:text-emerald-300/70">{{ __('Latest inventory movements and stock activity') }}</p>
                    </div>
                </div>

                <a
                    href="{{ route('inventory-history') }}"
                    wire:navigate
                    class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200/70 bg-emerald-50/80 px-3.5 py-1.5 text-xs font-semibold text-emerald-800 transition-colors hover:bg-emerald-100 dark:border-emerald-800/40 dark:bg-emerald-950/50 dark:text-emerald-300 dark:hover:bg-emerald-900/60"
                >
                    <span>{{ __('View All') }}</span>
                    <flux:icon name="arrow-right" class="size-3" />
                </a>
            </div>

            @if($recentTransactions->isEmpty())
                <div class="rounded-xl border border-dashed border-stone-200 py-10 text-center dark:border-emerald-900/30">
                    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-stone-100 text-stone-400 dark:bg-emerald-950/40 dark:text-emerald-400">
                        <flux:icon name="clock" class="size-6" />
                    </div>
                    <div class="mt-2 text-sm font-medium text-stone-600 dark:text-stone-300">{{ __('No transactions yet') }}</div>
                    <div class="text-xs text-stone-400 dark:text-stone-500">{{ __('Stock movements will appear here once recorded') }}</div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-stone-100 bg-[#FAF8F5] text-[11px] font-bold uppercase tracking-wider text-stone-600 dark:border-emerald-900/30 dark:bg-[#0E1A15] dark:text-emerald-400">
                                <th class="rounded-l-lg py-2.5 px-3.5">{{ __('Date') }}</th>
                                <th class="py-2.5 px-3.5">{{ __('Item') }}</th>
                                <th class="py-2.5 px-3.5">{{ __('Type') }}</th>
                                <th class="py-2.5 px-3.5 text-right">{{ __('Qty') }}</th>
                                <th class="rounded-r-lg py-2.5 px-3.5">{{ __('User') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 dark:divide-emerald-950/30">
                            @foreach($recentTransactions as $transaction)
                                <tr class="transition-colors hover:bg-[#F9FAF8] dark:hover:bg-emerald-950/30">
                                    <td class="py-3 px-3.5 text-stone-500 dark:text-stone-400 font-medium whitespace-nowrap">
                                        {{ $transaction->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="py-3 px-3.5 font-semibold text-stone-900 dark:text-stone-100">
                                        {{ $transaction->product->name }}
                                    </td>
                                    <td class="py-3 px-3.5">
                                        @if($transaction->type->value === 'stock_in')
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/80 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800/40 dark:bg-emerald-950/80 dark:text-emerald-300">
                                                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                                {{ __('Stock In') }}
                                            </span>
                                        @elseif($transaction->type->value === 'stock_out')
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200/80 bg-rose-50 px-2.5 py-0.5 text-xs font-semibold text-rose-800 dark:border-rose-800/40 dark:bg-rose-950/80 dark:text-rose-300">
                                                <span class="size-1.5 rounded-full bg-rose-500"></span>
                                                {{ __('Stock Out') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200/80 bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800 dark:border-amber-800/40 dark:bg-amber-950/80 dark:text-amber-300">
                                                <span class="size-1.5 rounded-full bg-amber-500"></span>
                                                {{ __('Adjustment') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3.5 text-right font-bold text-stone-800 dark:text-stone-200">
                                        {{ number_format($transaction->quantity) }}
                                    </td>
                                    <td class="py-3 px-3.5 text-stone-600 dark:text-stone-300">
                                        {{ $transaction->user->name ?? '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Recently Added Products Table Card -->
        <div class="rounded-2xl border border-[#E8E4DC] bg-white p-6 shadow-xs transition-shadow hover:shadow-md dark:border-emerald-950/40 dark:bg-[#12221B]">
            <div class="mb-5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-teal-100 text-teal-800 dark:bg-teal-900/40 dark:text-teal-300">
                        <flux:icon name="cube" class="size-5" />
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Recently Added Products') }}</h3>
                        <p class="text-xs text-stone-500 dark:text-emerald-300/70">{{ __('Newest catalogue items and inventory levels') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a
                        href="{{ route('products.create') }}"
                        wire:navigate
                        class="inline-flex items-center gap-1 rounded-xl bg-emerald-700 px-3 py-1.5 text-xs font-semibold text-white shadow-2xs transition-colors hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500"
                    >
                        <flux:icon name="plus" class="size-3.5" />
                        <span>{{ __('Add Product') }}</span>
                    </a>
                    <a
                        href="{{ route('products.index') }}"
                        wire:navigate
                        class="inline-flex items-center gap-1.5 rounded-xl border border-stone-200 bg-stone-50/80 px-3.5 py-1.5 text-xs font-semibold text-stone-700 transition-colors hover:bg-stone-100 dark:border-emerald-800/40 dark:bg-emerald-950/50 dark:text-emerald-300 dark:hover:bg-emerald-900/60"
                    >
                        <span>{{ __('View All') }}</span>
                        <flux:icon name="arrow-right" class="size-3" />
                    </a>
                </div>
            </div>

            @if($recentProducts->isEmpty())
                <div class="rounded-xl border border-dashed border-stone-200 py-10 text-center dark:border-emerald-900/30">
                    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-stone-100 text-stone-400 dark:bg-emerald-950/40 dark:text-emerald-400">
                        <flux:icon name="cube" class="size-6" />
                    </div>
                    <div class="mt-2 text-sm font-medium text-stone-600 dark:text-stone-300">{{ __('No products yet') }}</div>
                    <a
                        href="{{ route('products.create') }}"
                        wire:navigate
                        class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-emerald-700 px-4 py-2 text-xs font-semibold text-white transition-colors hover:bg-emerald-800"
                    >
                        <flux:icon name="plus" class="size-4" />
                        <span>{{ __('Add Product') }}</span>
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-stone-100 bg-[#FAF8F5] text-[11px] font-bold uppercase tracking-wider text-stone-600 dark:border-emerald-900/30 dark:bg-[#0E1A15] dark:text-emerald-400">
                                <th class="rounded-l-lg py-2.5 px-3.5">{{ __('Item') }}</th>
                                <th class="py-2.5 px-3.5">{{ __('Category') }}</th>
                                <th class="py-2.5 px-3.5 text-right">{{ __('Qty') }}</th>
                                <th class="rounded-r-lg py-2.5 px-3.5">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100 dark:divide-emerald-950/30">
                            @foreach($recentProducts as $product)
                                <tr wire:navigate href="{{ route('products.show', $product) }}" class="cursor-pointer transition-colors hover:bg-[#F9FAF8] dark:hover:bg-emerald-950/30">
                                    <td class="py-3 px-3.5 font-semibold text-stone-900 dark:text-stone-100">
                                        {{ $product->name }}
                                    </td>
                                    <td class="py-3 px-3.5 text-stone-500 dark:text-stone-400">
                                        {{ $product->category->name ?? '—' }}
                                    </td>
                                    <td class="py-3 px-3.5 text-right font-bold text-stone-800 dark:text-stone-200">
                                        {{ number_format($product->quantity) }} <span class="text-xs font-normal text-stone-500 dark:text-stone-400">{{ $product->unit }}</span>
                                    </td>
                                    <td class="py-3 px-3.5">
                                        @if($product->isOutOfStock())
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-200/80 bg-rose-50 px-2.5 py-0.5 text-xs font-semibold text-rose-800 dark:border-rose-800/40 dark:bg-rose-950/80 dark:text-rose-300">
                                                <span class="size-1.5 rounded-full bg-rose-500"></span>
                                                {{ __('Out of Stock') }}
                                            </span>
                                        @elseif($product->isLowStock())
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-200/80 bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-800 dark:border-amber-800/40 dark:bg-amber-950/80 dark:text-amber-300">
                                                <span class="size-1.5 rounded-full bg-amber-500"></span>
                                                {{ __('Low Stock') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200/80 bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-800 dark:border-emerald-800/40 dark:bg-emerald-950/80 dark:text-emerald-300">
                                                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                                {{ __('In Stock') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>