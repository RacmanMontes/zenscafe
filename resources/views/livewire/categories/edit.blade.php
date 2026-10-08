<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2 text-sm text-stone-500 dark:text-emerald-300/60">
                    <flux:button variant="subtle" size="sm" :href="route('categories.index')" wire:navigate class="rounded-lg">
                        {{ __('Categories') }}
                    </flux:button>
                    <span>/</span>
                    <span class="font-medium text-stone-700 dark:text-emerald-200">{{ __('Edit') }}</span>
                </div>
                <h1 class="cafe-page-title mt-2">{{ __('Edit Category') }}</h1>
                <p class="cafe-page-subtitle">{{ __('Update category details for :name', ['name' => $category->name]) }}</p>
            </div>
        </div>

        <div class="cafe-card p-6">
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

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="check" class="rounded-xl">
                        {{ __('Update Category') }}
                    </flux:button>
                    <flux:button variant="subtle" :href="route('categories.index')" wire:navigate class="rounded-xl">
                        {{ __('Cancel') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>