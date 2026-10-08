<?php

namespace App\Livewire\Stock;

use App\Actions\Inventory\AdjustInventory;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inventory Adjustment')]
class Adjustment extends Component
{
    public ?int $product_id = null;

    public int $adjustment = 0;

    public ?string $reason = null;

    public ?string $notes = null;

    protected function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'adjustment' => ['required', 'integer', 'not_in:0'],
            'reason' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function submit(AdjustInventory $action): void
    {
        $validated = $this->validate();

        $product = Product::findOrFail($validated['product_id']);

        $action->execute(
            product: $product,
            adjustment: $validated['adjustment'],
            reason: $validated['reason'],
            notes: $validated['notes'] ?? null,
            request: request(),
        );

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Inventory adjusted successfully. New quantity: ').$product->fresh()->quantity);
        $this->reset(['product_id', 'adjustment', 'reason', 'notes']);
    }

    public function render()
    {
        return view('livewire.stock.adjustment', [
            'products' => Product::where('status', 'active')->orderBy('name')->get(),
            'reasons' => [
                'Physical count correction',
                'Damaged item',
                'Expired item',
                'Data correction',
                'Initial inventory',
            ],
        ]);
    }
}
