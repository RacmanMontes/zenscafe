<div>
    <div class="flex flex-col gap-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <flux:heading size="xl">{{ __('Suppliers') }}</flux:heading>
                <flux:text class="mt-1">{{ __('Manage your product suppliers') }}</flux:text>
            </div>
            <flux:button variant="primary" icon="plus" :href="route('suppliers.create')" wire:navigate>
                {{ __('Add Supplier') }}
            </flux:button>
        </div>

        <flux:card>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <flux:field>
                    <flux:input wire:model.live="search" placeholder="{{ __('Search suppliers...') }}" icon="magnifying-glass" />
                </flux:field>
            </div>
        </flux:card>

        <flux:card>
            @if($suppliers->isEmpty())
                <div class="text-center py-12">
                    <flux:icon name="truck" class="mx-auto size-12 text-zinc-400 dark:text-zinc-500" />
                    <flux:heading size="sm" class="mt-4">{{ __('No suppliers found') }}</flux:heading>
                    <flux:text class="mt-1">{{ __('Get started by adding your first supplier.') }}</flux:text>
                    <flux:button variant="primary" class="mt-4" :href="route('suppliers.create')" wire:navigate>
                        {{ __('Add Supplier') }}
                    </flux:button>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-zinc-200 dark:border-zinc-700">
                                <th class="pb-3 text-left font-medium">{{ __('Name') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Contact') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Email') }}</th>
                                <th class="pb-3 text-left font-medium">{{ __('Phone') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Products') }}</th>
                                <th class="pb-3 text-right font-medium">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($suppliers as $supplier)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                    <td class="py-3 font-medium">{{ $supplier->name }}</td>
                                    <td class="py-3 text-zinc-500">{{ $supplier->contact_person ?? '—' }}</td>
                                    <td class="py-3 text-zinc-500">{{ $supplier->email ?? '—' }}</td>
                                    <td class="py-3 text-zinc-500">{{ $supplier->phone ?? '—' }}</td>
                                    <td class="py-3 text-right">{{ $supplier->products_count }}</td>
                                    <td class="py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <flux:button variant="subtle" size="sm" icon="pencil" :href="route('suppliers.edit', $supplier)" wire:navigate>
                                                {{ __('Edit') }}
                                            </flux:button>
                                            <flux:button variant="subtle" size="sm" icon="trash" @click="$wire.confirmArchive({{ $supplier->id }})">
                                                {{ __('Archive') }}
                                            </flux:button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </flux:card>
    </div>

    <flux:modal wire:model="showArchiveModal">
        <flux:heading>{{ __('Archive Supplier') }}</flux:heading>
        <flux:text class="mt-2">
            {{ __('Are you sure you want to archive this supplier?') }}
        </flux:text>
        <div class="mt-6 flex justify-end gap-2">
            <flux:button variant="subtle" @click="$wire.set('showArchiveModal', false)">
                {{ __('Cancel') }}
            </flux:button>
            <flux:button variant="danger" wire:click="archive">
                {{ __('Archive') }}
            </flux:button>
        </div>
    </flux:modal>
</div>