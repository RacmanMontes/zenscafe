<div>
    <div class="flex flex-col gap-6 max-w-2xl">
        <div>
            <div class="flex items-center gap-2 text-sm text-zinc-500">
                <flux:button variant="subtle" size="sm" :href="route('users.index')" wire:navigate>
                    {{ __('Users') }}
                </flux:button>
                <span>/</span>
                <span>{{ __('Edit') }}</span>
            </div>
            <flux:heading size="xl" class="mt-2">{{ __('Edit User') }}</flux:heading>
        </div>

        <flux:card>
            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Name') }}</flux:label>
                        <flux:input wire:model="name" placeholder="{{ __('Full name') }}" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Email') }}</flux:label>
                        <flux:input type="email" wire:model="email" placeholder="{{ __('Email address') }}" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('New Password') }}</flux:label>
                        <flux:input type="password" wire:model="password" placeholder="{{ __('Leave blank to keep current') }}" />
                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Confirm New Password') }}</flux:label>
                        <flux:input type="password" wire:model="password_confirmation" placeholder="{{ __('Confirm password') }}" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Role') }}</flux:label>
                        <flux:select wire:model="role">
                            <flux:select.option value="staff">{{ __('Staff') }}</flux:select.option>
                            <flux:select.option value="admin">{{ __('Admin') }}</flux:select.option>
                        </flux:select>
                        <flux:error name="role" />
                    </flux:field>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('Update User') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('users.index')" wire:navigate>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>