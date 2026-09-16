<div>
    <div class="flex flex-col gap-6 max-w-2xl">
        <div>
            <flux:heading size="xl">{{ __('Inventory Adjustment') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Adjust inventory quantities with proper reason tracking') }}</flux:text>
        </div>

        <flux:card>
            <form wire:submit="submit" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Product') }}</flux:label>
                    <flux:select wire:model="product_id" placeholder="{{ __('Select a product') }}">
                        @foreach($products as $product)
                            <flux:select.option value="{{ $product->id }}">
                                {{ $product->name }} ({{ $product->sku }}) — Current: {{ $product->quantity }} {{ $product->unit }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="product_id" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Adjustment Amount') }}</flux:label>
                    <flux:text class="text-sm text-zinc-500">{{ __('Use positive number to add, negative to subtract') }}</flux:text>
                    <flux:input type="number" wire:model="adjustment" placeholder="{{ __('e.g., 10 or -5') }}" />
                    <flux:error name="adjustment" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Reason') }}</flux:label>
                    <flux:select wire:model="reason" placeholder="{{ __('Select a reason') }}">
                        @foreach($reasons as $reason)
                            <flux:select.option value="{{ $reason }}">{{ $reason }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="reason" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Notes') }}</flux:label>
                    <flux:textarea wire:model="notes" placeholder="{{ __('Optional additional notes') }}" rows="2" />
                    <flux:error name="notes" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2">
                    <flux:button type="submit" variant="primary" icon="adjustments-horizontal">
                        {{ __('Submit Adjustment') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>