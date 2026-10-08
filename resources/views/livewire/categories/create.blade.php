<div>
    <div class="flex w-full flex-col gap-6">
        <div class="flex items-center gap-3">
            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                <flux:icon name="folder" class="size-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#0D3326] dark:text-emerald-100">{{ __('Add New Category') }}</h3>
                <p class="text-sm text-stone-500 dark:text-emerald-300/60">{{ __('Create a category to organize your café products') }}</p>
            </div>
        </div>

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

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                <flux:button variant="subtle" wire:click="cancelCreate" class="rounded-xl">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                    {{ __('Create Category') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>