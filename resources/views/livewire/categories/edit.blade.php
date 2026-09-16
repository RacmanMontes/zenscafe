<div>
    <div class="flex flex-col gap-6 max-w-2xl">
        <div>
            <div class="flex items-center gap-2 text-sm text-zinc-500">
                <flux:button variant="subtle" size="sm" :href="route('categories.index')" wire:navigate>
                    {{ __('Categories') }}
                </flux:button>
                <span>/</span>
                <span>{{ __('Edit') }}</span>
            </div>
            <flux:heading size="xl" class="mt-2">{{ __('Edit Category') }}</flux:heading>
        </div>

        <flux:card>
            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Category Name') }}</flux:label>
                    <flux:input wire:model="name" placeholder="{{ __('Enter category name') }}" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Description') }}</flux:label>
                    <flux:textarea wire:model="description" placeholder="{{ __('Optional description') }}" rows="3" />
                    <flux:error name="description" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2">
                    <flux:button type="submit" variant="primary" icon="check">
                        {{ __('Update Category') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('categories.index')" wire:navigate>
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>