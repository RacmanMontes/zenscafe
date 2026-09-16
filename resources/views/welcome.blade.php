<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        @include('partials.head', ['title' => __('Welcome')])

        <meta name="description" content="ZEN'S CAFE: Web-Based Inventory Management System. Manage cafe inventory efficiently with a centralized system for monitoring stock, inventory movements, suppliers, and essential inventory records.">

        <style>
            @keyframes fade-up {
                from { opacity: 0; transform: translateY(16px); }
                to { opacity: 1; transform: translateY(0); }
            }

            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }

            .animate-fade-up { animation: fade-up 0.6s ease-out both; }
            .animate-float { animation: float 7s ease-in-out infinite; }

            @media (prefers-reduced-motion: reduce) {
                .animate-fade-up,
                .animate-float { animation: none; }
            }
        </style>
    </head>
    <body class="overflow-x-hidden bg-stone-50 font-sans text-stone-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:start-4 focus:top-4 focus:z-50 focus:rounded-md focus:bg-stone-900 focus:px-4 focus:py-2 focus:text-white">
            {{ __('Skip to content') }}
        </a>

        {{-- Header --}}
        <header class="sticky top-0 z-40 border-b border-stone-200/80 bg-white/80 backdrop-blur-md dark:border-zinc-800/80 dark:bg-zinc-950/80">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <a href="#home" class="group flex items-center gap-2.5" aria-label="{{ __('ZEN\'S CAFE home') }}">
                    <span class="flex aspect-square size-10 items-center justify-center rounded-lg bg-white shadow-sm transition-transform group-hover:scale-105 dark:bg-zinc-900">
                        <x-app-logo-icon class="size-8" />
                    </span>
                    <span class="text-sm font-semibold tracking-wide uppercase">
                        {{ __('ZEN\'S CAFE') }}
                    </span>
                </a>

               

                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-stone-900 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-stone-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900 dark:bg-white dark:text-stone-950 dark:hover:bg-stone-200 dark:focus-visible:outline-white">
                            <flux:icon name="layout-grid" class="size-4" />
                            {{ __('Go to Dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" wire:navigate class="hidden rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-semibold text-stone-900 shadow-sm transition-colors hover:bg-stone-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900 lg:inline-flex dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-zinc-800 dark:focus-visible:outline-white">
                            {{ __('Login') }}
                        </a>
                    @endauth

                    <button
                        type="button"
                        id="menu-button"
                        class="inline-flex size-10 items-center justify-center rounded-lg border border-stone-300 bg-white text-stone-900 shadow-sm transition-colors hover:bg-stone-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900 lg:hidden dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:bg-zinc-800 dark:focus-visible:outline-white"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="{{ __('Toggle navigation menu') }}"
                    >
                        <flux:icon name="bars-2" class="size-5" />
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden border-t border-stone-200/80 bg-white/95 backdrop-blur-md lg:hidden dark:border-zinc-800/80 dark:bg-zinc-950/95">
                <nav class="space-y-1 px-4 py-3" aria-label="{{ __('Mobile navigation') }}">
                  
                    <div class="pt-2">
                        @auth
                            <a href="{{ route('dashboard') }}" wire:navigate class="flex w-full items-center justify-center gap-2 rounded-lg bg-stone-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm dark:bg-white dark:text-stone-950">
                                <flux:icon name="layout-grid" class="size-4" />
                                {{ __('Go to Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" wire:navigate class="flex w-full items-center justify-center rounded-lg bg-stone-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm dark:bg-white dark:text-stone-950">
                                {{ __('Login') }}
                            </a>
                        @endauth
                    </div>
                </nav>
            </div>
        </header>

        <main id="main">
            {{-- Hero --}}
            <section id="home" class="relative scroll-mt-24">
                <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[42rem] overflow-hidden" aria-hidden="true">
                    <div class="absolute left-1/2 top-[-12rem] h-[30rem] w-[64rem] -translate-x-1/2 rounded-full bg-amber-200/40 blur-3xl dark:bg-amber-500/10"></div>
                    <div class="absolute right-[-10rem] top-32 h-[20rem] w-[28rem] rounded-full bg-orange-100/60 blur-3xl dark:bg-orange-500/5"></div>
                    <div class="absolute bottom-0 left-[-8rem] h-[18rem] w-[26rem] rounded-full bg-yellow-100/50 blur-3xl dark:bg-yellow-500/5"></div>
                </div>

                <div class="mx-auto grid max-w-7xl grid-cols-1 items-center gap-14 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:gap-10 lg:px-8 lg:py-24">
                    <div class="max-w-xl animate-fade-up">
                        <p class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-medium text-amber-800 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                            <flux:icon name="shield-check" class="size-4" />
                            {{ __('Web-Based Inventory Management System') }}
                        </p>

                        <h1 class="mt-6 text-4xl font-semibold leading-tight tracking-tight text-balance sm:text-5xl lg:text-6xl">
                            {{ __('Smart Inventory Management') }}
                            <span class="text-amber-600 dark:text-amber-400">{{ __('for Zen\'s Cafe') }}</span>
                        </h1>

                        <p class="mt-6 max-w-lg text-lg leading-relaxed text-pretty text-stone-600 dark:text-zinc-400">
                            {{ __('Manage your cafe inventory efficiently with a centralized web-based system for monitoring stock, inventory movements, suppliers, and essential inventory records.') }}
                        </p>

                        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                            @auth
                                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-amber-600/25 transition-colors hover:bg-amber-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 dark:bg-amber-500 dark:text-stone-950 dark:hover:bg-amber-400 dark:focus-visible:outline-amber-400">
                                    <flux:icon name="layout-grid" class="size-4" />
                                    {{ __('Go to Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center justify-center gap-2 rounded-lg bg-amber-600 px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-amber-600/25 transition-colors hover:bg-amber-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600 dark:bg-amber-500 dark:text-stone-950 dark:hover:bg-amber-400 dark:focus-visible:outline-amber-400">
                                    <flux:icon name="arrow-right" class="size-4" />
                                    {{ __('Login to System') }}
                                </a>
                            @endauth

                            <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-lg border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-900 shadow-sm transition-colors hover:border-stone-400 hover:bg-stone-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-stone-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100 dark:hover:border-zinc-600 dark:hover:bg-zinc-800 dark:focus-visible:outline-white">
                                {{ __('Explore Features') }}
                                <flux:icon name="arrow-down" class="size-4" />
                            </a>
                        </div>
                    </div>

                    {{-- Hero visual --}}
                    <div class="relative mx-auto w-full max-w-md animate-fade-up lg:max-w-lg" style="animation-delay: 150ms">
                        <div class="relative rounded-2xl border border-stone-200 bg-white p-6 shadow-xl shadow-stone-900/5 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/30">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="flex size-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                                        <flux:icon name="square-3-stack-3d" class="size-5" />
                                    </span>
                                    <span class="text-sm font-semibold">{{ __('Inventory Overview') }}</span>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                    {{ __('Stock levels up to date') }}
                                </span>
                            </div>

                            <div class="mt-5 space-y-3">
                                @foreach([
                                    ['name' => 'Espresso Beans', 'status' => 'In Stock', 'dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400'],
                                    ['name' => 'Whole Milk', 'status' => 'Low Stock', 'dot' => 'bg-amber-500', 'badge' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400'],
                                    ['name' => 'Paper Cups', 'status' => 'In Stock', 'dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400'],
                                    ['name' => 'Vanilla Syrup', 'status' => 'Out of Stock', 'dot' => 'bg-red-500', 'badge' => 'bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400'],
                                ] as $row)
                                    <div class="flex items-center justify-between rounded-lg border border-stone-100 bg-stone-50 px-3.5 py-2.5 dark:border-zinc-800 dark:bg-zinc-800/60">
                                        <span class="flex items-center gap-2 text-sm text-stone-700 dark:text-zinc-300">
                                            <span class="size-2 shrink-0 rounded-full {{ $row['dot'] }}"></span>
                                            {{ $row['name'] }}
                                        </span>
                                        <span class="hidden rounded-full {{ $row['badge'] }} px-2.5 py-0.5 text-xs font-medium sm:inline">
                                            {{ $row['status'] }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="absolute -bottom-8 -start-4 w-64 rounded-xl border border-stone-200 bg-white p-4 shadow-lg shadow-stone-900/5 animate-float sm:-start-8 dark:border-zinc-800 dark:bg-zinc-900 dark:shadow-black/30">
                            <p class="text-xs font-semibold tracking-wide text-stone-500 uppercase dark:text-zinc-400">
                                {{ __('Recent Movements') }}
                            </p>
                            <div class="mt-2.5 space-y-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="flex size-6 shrink-0 items-center justify-center rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <flux:icon name="arrow-down" class="size-3.5" />
                                    </span>
                                    <span class="text-stone-700 dark:text-zinc-300">{{ __('Stock In · Roasted Coffee') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="flex size-6 shrink-0 items-center justify-center rounded-md bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400">
                                        <flux:icon name="arrow-up" class="size-3.5" />
                                    </span>
                                    <span class="text-stone-700 dark:text-zinc-300">{{ __('Stock Out · Bottled Water') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-4 -end-2 hidden items-center gap-2 rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-medium text-stone-700 shadow-lg animate-float sm:flex lg:-end-6 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300" style="animation-delay: 1.2s">
                            <flux:icon name="presentation-chart-line" class="size-4 text-amber-600 dark:text-amber-400" />
                            {{ __('Low-stock monitoring ready') }}
                        </div>
                    </div>
                </div>
            </section>

            {{-- Features --}}
            <section id="features" class="scroll-mt-24 py-16 lg:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-semibold tracking-tight text-balance sm:text-4xl">
                            {{ __('Everything You Need to Manage Inventory') }}
                        </h2>
                        <p class="mt-4 text-lg leading-relaxed text-pretty text-stone-600 dark:text-zinc-400">
                            {{ __('A complete set of tools to organize records, track movements, and keep your cafe inventory under control.') }}
                        </p>
                    </div>

                    <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach([
                            ['icon' => 'cube', 'title' => 'Inventory Management', 'text' => 'Organize and manage inventory items in one centralized system.'],
                            ['icon' => 'eye', 'title' => 'Stock Monitoring', 'text' => 'Track current stock levels and quickly identify low-stock and out-of-stock items.'],
                            ['icon' => 'arrows-right-left', 'title' => 'Stock-In and Stock-Out', 'text' => 'Record inventory movements accurately and maintain updated stock quantities.'],
                            ['icon' => 'truck', 'title' => 'Supplier Management', 'text' => 'Keep supplier information organized and accessible.'],
                            ['icon' => 'clock', 'title' => 'Inventory History', 'text' => 'Review inventory movements and maintain a reliable transaction history.'],
                            ['icon' => 'document-chart-bar', 'title' => 'Inventory Reports', 'text' => 'Generate organized reports to help monitor inventory status and movements.'],
                        ] as $feature)
                            <div class="group rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:border-amber-300 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-amber-500/40">
                                <span class="flex size-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700 transition-colors group-hover:bg-amber-600 group-hover:text-white dark:bg-amber-500/10 dark:text-amber-400 dark:group-hover:bg-amber-500 dark:group-hover:text-stone-950">
                                    <flux:icon :name="$feature['icon']" class="size-6" />
                                </span>
                                <h3 class="mt-4 text-base font-semibold">{{ $feature['title'] }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-stone-600 dark:text-zinc-400">{{ $feature['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- How it works --}}
            <section id="how-it-works" class="scroll-mt-24 bg-white py-16 lg:py-24 dark:bg-zinc-900/40">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-3xl font-semibold tracking-tight text-balance sm:text-4xl">
                            {{ __('How the System Works') }}
                        </h2>
                        <p class="mt-4 text-lg leading-relaxed text-pretty text-stone-600 dark:text-zinc-400">
                            {{ __('Three simple steps to keep your inventory organized and under control.') }}
                        </p>
                    </div>

                    <div class="relative mt-14 grid grid-cols-1 gap-10 lg:grid-cols-3 lg:gap-8">
                        @foreach([
                            ['step' => '01', 'icon' => 'cube', 'title' => 'Manage Inventory', 'text' => 'Add and organize inventory items, categories, and suppliers.'],
                            ['step' => '02', 'icon' => 'arrows-right-left', 'title' => 'Track Stock', 'text' => 'Record stock-in, stock-out, and inventory adjustments.'],
                            ['step' => '03', 'icon' => 'presentation-chart-line', 'title' => 'Monitor and Review', 'text' => 'Review inventory status, history, low-stock items, and reports.'],
                        ] as $index => $step)
                            <div class="relative text-center lg:px-6">
                                <div class="mx-auto flex size-14 items-center justify-center rounded-2xl border border-amber-200 bg-amber-50 text-amber-700 shadow-sm dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-400">
                                    <flux:icon :name="$step['icon']" class="size-7" />
                                </div>
                                <p class="mt-5 text-sm font-semibold tracking-widest text-amber-600 uppercase dark:text-amber-400">
                                    {{ __('Step') }} {{ $step['step'] }}
                                </p>
                                <h3 class="mt-1.5 text-lg font-semibold">{{ $step['title'] }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-stone-600 dark:text-zinc-400">{{ $step['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- Benefits --}}
            <section id="benefits" class="scroll-mt-24 py-16 lg:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-3xl border border-stone-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <div class="relative overflow-hidden bg-stone-900 p-8 text-white sm:p-12 dark:bg-zinc-800">
                                <div class="pointer-events-none absolute -top-16 -end-16 size-56 rounded-full bg-amber-500/20 blur-3xl" aria-hidden="true"></div>
                                <p class="text-sm font-semibold tracking-widest text-amber-400 uppercase">
                                    {{ __('System Benefits') }}
                                </p>
                                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-balance">
                                    {{ __('Designed to Make Inventory Work Easier') }}
                                </h2>
                                <p class="mt-4 max-w-md leading-relaxed text-white/70">
                                    {{ __('Keep your cafe running smoothly with a system built around clear records and reliable monitoring.') }}
                                </p>
                                <div class="mt-8">
                                    @auth
                                        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-stone-950 transition-colors hover:bg-amber-400">
                                            {{ __('Go to Dashboard') }}
                                            <flux:icon name="arrow-right" class="size-4" />
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-stone-950 transition-colors hover:bg-amber-400">
                                            {{ __('Login to System') }}
                                            <flux:icon name="arrow-right" class="size-4" />
                                        </a>
                                    @endauth
                                </div>
                            </div>

                            <div class="p-8 sm:p-12">
                                <ul class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                    @foreach([
                                        'More organized inventory records',
                                        'Reduced manual recording',
                                        'Better stock visibility',
                                        'Easier inventory monitoring',
                                        'Centralized information',
                                        'Improved operational efficiency',
                                    ] as $benefit)
                                        <li class="flex items-start gap-3">
                                            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                                <flux:icon name="check" class="size-4" />
                                            </span>
                                            <span class="text-sm font-medium text-stone-700 dark:text-zinc-300">{{ $benefit }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- About --}}
            <section id="about" class="scroll-mt-24 py-16 lg:py-24">
                <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                    <span class="flex aspect-square size-16 items-center justify-center rounded-2xl bg-white shadow-sm dark:bg-zinc-900">
                        <x-app-logo-icon class="size-12" />
                    </span>
                    <h2 class="mt-6 text-3xl font-semibold tracking-tight text-balance sm:text-4xl">
                        {{ __('Built for Better Inventory Management') }}
                    </h2>
                    <p class="mt-5 text-lg leading-relaxed text-pretty text-stone-600 dark:text-zinc-400">
                        {{ __("ZEN'S CAFE: WEB-BASED INVENTORY MANAGEMENT SYSTEM is designed to provide Zen's Cafe with a centralized and efficient way to manage and monitor its inventory. The system helps authorized personnel maintain organized inventory records and track inventory movements.") }}
                    </p>
                </div>
            </section>

            {{-- Call to action --}}
            <section id="cta" class="pb-16 lg:pb-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="relative overflow-hidden rounded-3xl bg-stone-900 px-6 py-16 text-center text-white shadow-xl sm:px-12 lg:py-20 dark:bg-zinc-900 dark:ring-1 dark:ring-zinc-800">
                        <div class="pointer-events-none absolute -top-24 left-1/2 h-72 w-[40rem] -translate-x-1/2 rounded-full bg-amber-500/20 blur-3xl" aria-hidden="true"></div>
                        <div class="relative">
                            <h2 class="mx-auto max-w-2xl text-3xl font-semibold tracking-tight text-balance sm:text-4xl">
                                {{ __('Ready to Manage Your Inventory Better?') }}
                            </h2>
                            <p class="mx-auto mt-4 max-w-xl text-lg leading-relaxed text-pretty text-white/70">
                                {{ __('Access the Zen\'s Cafe inventory management system and keep your inventory organized.') }}
                            </p>
                            <div class="mt-8">
                                @auth
                                    <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950 shadow-sm transition-colors hover:bg-amber-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400">
                                        <flux:icon name="layout-grid" class="size-4" />
                                        {{ __('Go to Dashboard') }}
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-6 py-3 text-sm font-semibold text-stone-950 shadow-sm transition-colors hover:bg-amber-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400">
                                        <flux:icon name="arrow-right" class="size-4" />
                                        {{ __('Login to System') }}
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        {{-- Footer --}}
        <footer class="border-t border-stone-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
            <div class="mx-auto flex max-w-7xl flex-col items-center gap-4 px-4 py-10 text-center sm:px-6 lg:px-8">
                <a href="#home" class="group flex items-center gap-2.5" aria-label="{{ __('ZEN\'S CAFE home') }}">
                    <span class="flex aspect-square size-9 items-center justify-center rounded-lg bg-white shadow-sm transition-transform group-hover:scale-105 dark:bg-zinc-900">
                        <x-app-logo-icon class="size-7" />
                    </span>
                    <span class="text-sm font-semibold tracking-wide uppercase">{{ __('ZEN\'S CAFE') }}</span>
                </a>

                <p class="text-sm text-stone-600 dark:text-zinc-400">
                    {{ __('Web-Based Inventory Management System') }}
                </p>

                <p class="text-xs text-stone-400 dark:text-zinc-500">
                    &copy; {{ now()->year }} {{ __('Zen\'s Cafe. All rights reserved.') }}
                </p>
            </div>
        </footer>

        <script>
            (() => {
                const button = document.getElementById('menu-button');
                const menu = document.getElementById('mobile-menu');

                if (!button || !menu) {
                    return;
                }

                const close = () => {
                    menu.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                };

                button.addEventListener('click', () => {
                    const willOpen = menu.classList.contains('hidden');
                    menu.classList.toggle('hidden', !willOpen);
                    button.setAttribute('aria-expanded', String(willOpen));
                });

                menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));

                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape' && !menu.classList.contains('hidden')) {
                        close();
                        button.focus();
                    }
                });
            })();
        </script>
    </body>
</html>