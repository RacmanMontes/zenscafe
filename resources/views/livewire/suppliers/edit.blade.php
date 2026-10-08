<div>
    <div class="flex w-full flex-col gap-6">
        <div class="flex items-center gap-3">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700 dark:bg-cyan-900/40 dark:text-cyan-300">
                <flux:icon name="building-storefront" class="size-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Edit Supplier') }}</h3>
                <p class="text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Update details for :name', ['name' => $supplier->name]) }}</p>
            </div>
        </div>

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

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                <flux:button variant="subtle" wire:click="cancelEdit" class="rounded-xl">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                    {{ __('Update Supplier') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>