<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <flux:heading size="xl">{{ __('Users') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Manage system users and roles') }}</flux:text>
            </div>
            <flux:button variant="primary" icon="plus" :href="route('users.create')" wire:navigate>
                {{ __('Add User') }}
            </flux:button>
        </div>

        <flux:card>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search users...') }}" icon="magnifying-glass" />
                </flux:field>
            </div>
        </flux:card>

        <flux:card>
            @if($users->isEmpty())
                <div class="text-center py-12">
                    <flux:icon name="users" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:heading size="sm" class="mt-4">{{ __('No users found') }}</flux:heading>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-3 text-left font-medium">{{ __('Name') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Email') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Role') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Status') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($users as $user)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-3">
                                        <div class="flex items-center gap-3">
                                            <flux:avatar :initials="ucfirst(substr($user->name, 0, 1))" class="size-8" />
                                            <div class="font-medium">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-zinc-500">{{ $user->email }}</td>
                                    <td class="py-3">
                                        @if($user->isAdmin())
                                            <flux:badge color="purple" size="sm">{{ __('Admin') }}</flux:badge>
                                        @else
                                            <flux:badge color="blue" size="sm">{{ __('Staff') }}</flux:badge>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($user->email_verified_at)
                                            <flux:badge color="green" size="sm">{{ __('Active') }}</flux:badge>
                                        @else
                                            <flux:badge color="red" size="sm">{{ __('Inactive') }}</flux:badge>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('users.edit', $user)" wire:navigate>
                                                {{ __('Edit') }}
                                            </flux:button>
                                            @if($user->id !== auth()->id())
                                                @if($user->email_verified_at)
                                                    <flux:button variant="subtle" size="sm" icon="no-symbol" wire:click="toggleStatus({{ $user->id }})">
                                                        {{ __('Deactivate') }}
                                                    </flux:button>
                                                @else
                                                    <flux:button variant="subtle" size="sm" icon="check-circle" wire:click="toggleStatus({{ $user->id }})">
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

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</div>