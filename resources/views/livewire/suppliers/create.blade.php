<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('suppliers.index')" wire:navigate class="rounded-lg">
                        {{ __('Suppliers') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Add New') }}</span>
                </div>
                <h1 class="cafe-page-title mt-2">{{ __('Add New Supplier') }}</h1>
                <p class="cafe-page-subtitle">{{ __('Add a supplier that provides your café products') }}</p>
            </div>
        </div>

        <div class="cafe-card p-6">
            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Supplier Name') }}</flux:label>
                        <flux:input wire:model="name" placeholder="{{ __('Enter supplier name') }}" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Contact Person') }}</flux:label>
                        <flux:input wire:model="contact_person" placeholder="{{ __('Contact person name') }}" />
                        <flux:error name="contact_person" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Email') }}</flux:label>
                        <flux:input type="email" wire:model="email" placeholder="{{ __('Email address') }}" />
                        <flux:error name="email" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Phone') }}</flux:label>
                        <flux:input wire:model="phone" placeholder="{{ __('Phone number') }}" />
                        <flux:error name="phone" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>{{ __('Address') }}</flux:label>
                    <flux:textarea wire:model="address" placeholder="{{ __('Supplier address') }}" rows="2" />
                    <flux:error name="address" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Notes') }}</flux:label>
                    <flux:textarea wire:model="notes" placeholder="{{ __('Additional notes') }}" rows="2" />
                    <flux:error name="notes" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                        {{ __('Create Supplier') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('suppliers.index')" wire:navigate class="rounded-xl">
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>