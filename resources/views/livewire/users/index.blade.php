<div>
    <div class="flex flex-col gap-6">
        <div class="cafe-card p-5">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search users...') }}" icon="magnifying-glass" />
                </flux:field>
                @if(!$users->isEmpty())
                    <div class="hidden lg:flex items-end text-sm text-stone-500 dark:text-emerald-300/60">
                        {{ $users->total() }} {{ __('users') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="cafe-card overflow-hidden p-0">
            @if($users->isEmpty())
                <div class="cafe-empty-state m-6">
                    <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300">
                        <flux:icon name="users" class="size-7" />
                    </div>
                    <h3 class="mt-4 text-base font-bold text-[#0D3326] dark:text-emerald-100">{{ __('No users found') }}</h3>
                    <p class="mt-1 text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Get started by adding your first team member.') }}</p>
                    <div class="mt-5">
                        <flux:button variant="primary" icon="plus" :href="route('users.create')" wire:navigate class="rounded-xl">
                            {{ __('Add User') }}
                        </flux:button>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="cafe-thead-row">
                                <th class="cafe-th">{{ __('Name') }}</th>
                                <th class="cafe-th">{{ __('Email') }}</th>
                                <th class="cafe-th">{{ __('Role') }}</th>
                                <th class="cafe-th">{{ __('Status') }}</th>
                                <th class="cafe-th-right">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="cafe-tbody">
                            @foreach($users as $user)
                                @php
                                    $isCurrent = $user->id === auth()->id();
                                    $avatarPalette = ['bg-gradient-to-br from-emerald-400 to-teal-600', 'bg-gradient-to-br from-sky-400 to-blue-600', 'bg-gradient-to-br from-purple-400 to-violet-600', 'bg-gradient-to-br from-amber-400 to-orange-600', 'bg-gradient-to-br from-rose-400 to-pink-600', 'bg-gradient-to-br from-cyan-400 to-teal-600'];
                                @endphp
                                <tr class="cafe-tr">
                                    <td class="cafe-td">
                                        <div class="flex items-center gap-3">
                                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl {{ $avatarPalette[$loop->index % count($avatarPalette)] }} text-sm font-bold text-white shadow-xs">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 font-semibold text-[#1A1A18] dark:text-stone-100">
                                                    {{ $user->name }}
                                                    @if($isCurrent)
                                                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">{{ __('You') }}</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-stone-500 dark:text-emerald-300/60">{{ $user->created_at->format('M d, Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cafe-td text-stone-600 dark:text-stone-300">{{ $user->email }}</td>
                                    <td class="cafe-td">
                                        @if($user->isAdmin())
                                            <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                                                <flux:icon name="shield-check" class="size-3" />
                                                {{ __('Admin') }}
                                            </span>
                                        @else
                                            <span class="cafe-status-pill border-sky-200/80 bg-sky-50 text-sky-700 dark:border-sky-800/40 dark:bg-sky-950/70 dark:text-sky-300">
                                                <flux:icon name="user" class="size-3" />
                                                {{ __('Staff') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="cafe-td">
                                        @if($user->email_verified_at)
                                            <span class="cafe-status-pill border-emerald-200/80 bg-emerald-50 text-emerald-700 dark:border-emerald-800/40 dark:bg-emerald-950/70 dark:text-emerald-300">
                                                <span class="cafe-status-pill-dot bg-emerald-500"></span>
                                                {{ __('Active') }}
                                            </span>
                                        @else
                                            <span class="cafe-status-pill border-rose-200/80 bg-rose-50 text-rose-700 dark:border-rose-800/40 dark:bg-rose-950/70 dark:text-rose-300">
                                                <span class="cafe-status-pill-dot bg-rose-500"></span>
                                                {{ __('Inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="cafe-td-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('users.edit', $user)" wire:navigate class="rounded-lg" title="{{ __('Edit') }}" aria-label="{{ __('Edit') }}">
                                                {{ __('Edit') }}
                                            </flux:button>
                                            @if($user->id !== auth()->id())
                                                @if($user->email_verified_at)
                                                    <flux:button variant="subtle" size="sm" icon="no-symbol" wire:click="toggleStatus({{ $user->id }})" class="rounded-lg text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-950/40" title="{{ __('Deactivate') }}" aria-label="{{ __('Deactivate') }}">
                                                        {{ __('Deactivate') }}
                                                    </flux:button>
                                                @else
                                                    <flux:button variant="subtle" size="sm" icon="check-circle" wire:click="toggleStatus({{ $user->id }})" class="rounded-lg text-emerald-700 hover:bg-emerald-50 hover:text-emerald-800 dark:text-emerald-400 dark:hover:bg-emerald-950/40" title="{{ __('Activate') }}" aria-label="{{ __('Activate') }}">
                                                        {{ __('Activate') }}
                                                    </flux:button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 border-t border-[#F1EDE6] px-4 py-4 dark:border-emerald-950/30">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

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
                href="{{ route('users.create') }}"
                wire:navigate
                title="{{ __('Add User') }}"
                aria-label="{{ __('Add User') }}"
                class="group flex h-10 min-w-10 cursor-grab select-none items-center justify-center overflow-hidden rounded-full bg-emerald-700 text-white no-underline shadow-lg shadow-emerald-900/25 transition-all duration-300 ease-out hover:justify-start hover:pl-4 hover:pr-5 hover:bg-emerald-800 active:cursor-grabbing dark:bg-emerald-500 dark:text-emerald-950 dark:hover:bg-emerald-400"
            >
                <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4.5v15m7.5-7.5h-15" /></svg>
                <span class="max-w-0 overflow-hidden whitespace-nowrap text-sm font-semibold opacity-0 transition-all duration-300 ease-out group-hover:ml-2 group-hover:max-w-40 group-hover:opacity-100">{{ __('Add User') }}</span>
            </a>
        </div>
    </div>
</div>