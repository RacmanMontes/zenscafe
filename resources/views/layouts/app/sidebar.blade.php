<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body
        class="min-h-screen bg-[#FBF9F5] font-sans text-stone-900 antialiased dark:bg-[#0E1714] dark:text-stone-100"
        x-data
        x-on:livewire:navigate.window="
            setTimeout(() => {
                const sidebar = document.querySelector('ui-sidebar');
                if (sidebar?.hasAttribute('data-flux-sidebar-on-mobile') && !sidebar.hasAttribute('data-flux-sidebar-collapsed-mobile')) {
                    sidebar.dispatchEvent(new CustomEvent('flux-sidebar-toggle', { bubbles: true }));
                }
            }, 0)
        "
    >
        <flux:sidebar sticky collapsible="true" class="cafe-sidebar border-e border-[#16382c] bg-[#0d281e] dark:border-[#133026] dark:bg-[#0a2018]">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <div class="grid px-3 pt-3 pb-1.5 in-data-flux-sidebar-collapsed-desktop:hidden">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-300/70 leading-none">{{ __('Overview') }}</div>
                </div>
                <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>

                <div class="grid px-3 pt-4 pb-1.5 in-data-flux-sidebar-collapsed-desktop:hidden">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-300/70 leading-none">{{ __('Inventory') }}</div>
                </div>
                <flux:sidebar.item icon="cube" :href="route('products.index')" :current="request()->routeIs('products.*')" wire:navigate>
                    {{ __('Products') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="folder" :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>
                    {{ __('Categories') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="truck" :href="route('suppliers.index')" :current="request()->routeIs('suppliers.*')" wire:navigate>
                    {{ __('Suppliers') }}
                </flux:sidebar.item>
                @if(auth()->user()->isAdmin())
                    <flux:sidebar.item icon="adjustments-horizontal" :href="route('stock-adjustment')" :current="request()->routeIs('stock-adjustment')" wire:navigate>
                        {{ __('Adjustment') }}
                    </flux:sidebar.item>
                @endif

                <div class="grid px-3 pt-4 pb-1.5 in-data-flux-sidebar-collapsed-desktop:hidden">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-300/70 leading-none">{{ __('Reports') }}</div>
                </div>
                <flux:sidebar.item icon="clock" :href="route('inventory-history')" :current="request()->routeIs('inventory-history')" wire:navigate>
                    {{ __('History') }}
                </flux:sidebar.item>
                <flux:sidebar.item icon="chart-bar" :href="route('reports')" :current="request()->routeIs('reports.*')" wire:navigate>
                    {{ __('Reports') }}
                </flux:sidebar.item>

                @if(auth()->user()->isAdmin())
                    <div class="grid px-3 pt-4 pb-1.5 in-data-flux-sidebar-collapsed-desktop:hidden">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-300/70 leading-none">{{ __('Administration') }}</div>
                    </div>
                    <flux:sidebar.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                        {{ __('Users') }}
                    </flux:sidebar.item>
                @endif
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Top Header -->
        <flux:header class="sticky top-0 z-10 border-b border-[#E8E4DC] bg-white/95 px-4 py-2.5 backdrop-blur-md dark:border-emerald-950/40 dark:bg-[#0E1A15]/95 sm:px-6 lg:px-8">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <div class="hidden lg:flex items-center gap-2.5">
                <div class="flex items-center gap-2 rounded-full border border-emerald-200/70 bg-emerald-50/80 px-3 py-1 text-xs font-semibold text-emerald-800 dark:border-emerald-800/40 dark:bg-emerald-950/60 dark:text-emerald-300">
                    <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Zen's Café</span>
                    <span class="text-emerald-400 dark:text-emerald-600">/</span>
                    <span class="font-medium text-emerald-700 dark:text-emerald-400">Inventory System</span>
                </div>
            </div>

            <flux:spacer />

            <div class="flex items-center gap-2 sm:gap-3">
                <livewire:alerts.low-stock-alerts panel="right" />

                <div class="h-5 w-px bg-stone-200 dark:bg-emerald-900/40"></div>

                <flux:dropdown position="bottom" align="end">
                    <button
                        type="button"
                        class="flex items-center gap-2.5 rounded-xl p-1 text-stone-700 transition-colors hover:bg-stone-100 focus:outline-none dark:text-stone-200 dark:hover:bg-emerald-900/30"
                        data-test="header-profile-button"
                    >
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            class="size-8 rounded-lg bg-emerald-100 font-bold text-emerald-800 ring-2 ring-emerald-600/20 dark:bg-emerald-900 dark:text-emerald-100"
                        />
                        <div class="hidden md:flex flex-col text-left leading-tight">
                            <span class="text-sm font-semibold text-stone-800 dark:text-stone-100">{{ auth()->user()->name }}</span>
                            <span class="text-[11px] font-medium text-emerald-700 dark:text-emerald-400 capitalize">{{ auth()->user()->role->value ?? 'User' }}</span>
                        </div>
                        <flux:icon name="chevron-down" class="size-3.5 text-stone-400 dark:text-stone-500" />
                    </button>

                    <flux:menu class="w-56 rounded-xl border border-stone-200 p-1.5 shadow-lg dark:border-zinc-700">
                        <div class="mb-1 border-b border-stone-100 p-2 dark:border-zinc-800">
                            <div class="truncate text-sm font-semibold text-stone-900 dark:text-stone-100">{{ auth()->user()->name }}</div>
                            <div class="truncate text-xs text-stone-500 dark:text-stone-400">{{ auth()->user()->email }}</div>
                        </div>

                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate class="rounded-lg">
                            {{ __('Settings') }}
                        </flux:menu.item>

                        <flux:menu.separator />

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer rounded-lg text-red-600 dark:text-red-400"
                                data-test="logout-button"
                            >
                                {{ __('Log out') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        <div
            wire:ignore
            x-cloak
            x-data="toastNotifications(
                { success: @js(session('success')), error: @js(session('error')) },
                { success: @js(__('Success')), error: @js(__('Error')) }
            )"
            x-on:zenscafe-toast.window="showToast($event.detail.variant, $event.detail.title, $event.detail.text)"
        ></div>

        @fluxScripts
    </body>
</html>
