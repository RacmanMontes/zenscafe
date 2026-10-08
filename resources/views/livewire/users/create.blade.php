<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('users.index')" wire:navigate class="rounded-lg">
                        {{ __('Users') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Add New') }}</span>
                </div>
                <h1 class="cafe-page-title mt-2">{{ __('Add New User') }}</h1>
                <p class="cafe-page-subtitle">{{ __('Create a new account for a team member') }}</p>
            </div>
        </div>

        <div class="cafe-card p-6">
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
                        <flux:label>{{ __('Password') }}</flux:label>
                        <flux:input type="password" wire:model="password" placeholder="{{ __('Password') }}" />
                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Confirm Password') }}</flux:label>
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

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                        {{ __('Create User') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('users.index')" wire:navigate class="rounded-xl">
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>