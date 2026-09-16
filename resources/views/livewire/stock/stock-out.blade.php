<div>
    <div class="flex flex-col gap-6 max-w-2xl">
        <div>
            <flux:heading size="xl">{{ __('Stock Out') }}</flux:heading>
            <flux:text class="mt-1">{{ __('Record outgoing inventory') }}</flux:text>
        </div>

        <flux:card>
            <form wire:submit="submit" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Product') }}</flux:label>
                    <flux:select wire:model="product_id" placeholder="{{ __('Select a product') }}">
                        @foreach($products as $product)
                            <flux:select.option value="{{ $product->id }}">
                                {{ $product->name }} ({{ $product->sku }}) — Available: {{ $product->quantity }} {{ $product->unit }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="product_id" />
                </flux:field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Quantity') }}</flux:label>
                        <flux:input type="number" wire:model="quantity" min="1" />
                        <flux:error name="quantity" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Date') }}</flux:label>
                        <flux:input type="date" wire:model="date" />
                        <flux:error name="date" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reason') }}</flux:label>
                        <flux:input wire:model="reason" placeholder="{{ __('e.g., Sale, Consumption, Waste') }}" />
                        <flux:error name="reason" />
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reference Number') }}</flux:label>
                        <flux:input wire:model="reference_number" placeholder="{{ __('Optional reference') }}" />
                        <flux:error name="reference_number" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>{{ __('Notes') }}</flux:label>
                    <flux:textarea wire:model="notes" placeholder="{{ __('Optional notes') }}" rows="2" />
                    <flux:error name="notes" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2">
                    <flux:button type="submit" variant="primary" icon="arrow-up-on-square">
                        {{ __('Record Stock Out') }}
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>