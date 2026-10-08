@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand :name="config('app.name', 'Laravel')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-1 shadow-md border border-emerald-400/30">
            <x-app-logo-icon class="size-7 text-white" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="config('app.name', 'Laravel')" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-[#0d281e] p-1 shadow-md border border-emerald-500/20">
            <x-app-logo-icon class="size-7 text-white" />
        </x-slot>
    </flux:brand>
@endif
