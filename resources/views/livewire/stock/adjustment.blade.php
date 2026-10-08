<div>
    <div class="flex w-full flex-col gap-6">
        <div class="cafe-page-header">
            <div>
                <div class="flex items-center gap-2.5">
                    <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-white shadow-xs">
                        <flux:icon name="adjustments-horizontal" class="size-5.5" />
                    </span>
                    <div>
                        <h1 class="cafe-page-title">{{ __('Inventory Adjustment') }}</h1>
                        <p class="cafe-page-subtitle">{{ __('Adjust inventory quantities with proper reason tracking') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="cafe-card p-6">
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-orange-200/70 bg-orange-50/70 p-4 text-sm text-orange-900 dark:border-orange-800/40 dark:bg-orange-950/40 dark:text-orange-200">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-orange-500/10 text-orange-700 dark:text-orange-300">
                    <flux:icon name="exclamation-triangle" class="size-4.5" />
                </span>
                <div>
                    <p class="font-semibold">{{ __('Correct stock levels manually') }}</p>
                    <p class="mt-0.5 text-orange-800/80 dark:text-orange-300/70">{{ __('Use a positive number to add stock or a negative number to subtract. An adjustment reason is required.') }}</p>
                </div>
            </div>

            <form wire:submit="submit" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Product') }}</flux:label>
                    <flux:select wire:model="product_id">
                        <flux:select.option value="">{{ __('Select a product') }}</flux:select.option>
                        @foreach($products as $product)
                            <flux:select.option value="{{ $product->id }}">
                                {{ $product->name }} ({{ $product->sku }}) — Current: {{ $product->quantity }} {{ $product->unit }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="product_id" />
                </flux:field>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Adjustment Amount') }}</flux:label>
                        <flux:input type="number" wire:model="adjustment" placeholder="{{ __('e.g., 10 or -5') }}" />
                        <flux:error name="adjustment" />
                        @if($adjustment != 0)
                            <flux:description>
                                @if((float) $adjustment > 0)
                                    <span class="inline-flex items-center gap-1 text-emerald-700 dark:text-emerald-300">
                                        <flux:icon name="arrow-down" class="size-3" />
                                        {{ __('This will increase stock by') }} {{ $adjustment }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-rose-700 dark:text-rose-300">
                                        <flux:icon name="arrow-up" class="size-3" />
                                        {{ __('This will decrease stock by') }} {{ abs($adjustment) }}
                                    </span>
                                @endif
                            </flux:description>
                        @endif
                    </flux:field>

                    <flux:field>
                        <flux:label>{{ __('Reason') }}</flux:label>
                        <flux:select wire:model="reason">
                            <flux:select.option value="">{{ __('Select a reason') }}</flux:select.option>
                            @foreach($reasons as $reason)
                                <flux:select.option value="{{ $reason }}">{{ $reason }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="reason" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>{{ __('Notes') }}</flux:label>
                    <flux:textarea wire:model="notes" placeholder="{{ __('Optional additional notes') }}" rows="2" />
                    <flux:error name="notes" />
                </flux:field>

                <div class="flex items-center gap-2 pt-2 border-t border-[#F1EDE6] dark:border-emerald-950/30">
                    <flux:button type="submit" variant="primary" icon="adjustments-horizontal" class="rounded-xl">
                        {{ __('Submit Adjustment') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>