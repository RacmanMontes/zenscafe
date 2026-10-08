<?php

namespace App\Livewire\Stock;

use App\Actions\Inventory\AdjustInventory;
use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
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

    public ?string $reference_number = null;

    protected function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'adjustment' => ['required', 'integer', 'not_in:0'],
            'reason' => ['required', 'string', 'max:255'],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function mount(): void
    {
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::Adjustment);
    }

    public function submit(AdjustInventory $action): void
    {
        $validated = $this->validate();

        $product = Product::findOrFail($validated['product_id']);

        $action->execute(
            product: $product,
            adjustment: $validated['adjustment'],
            reason: $validated['reason'],
            referenceNumber: $validated['reference_number'] ?? null,
            notes: $validated['notes'] ?? null,
            request: request(),
        );

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Inventory adjusted successfully. New quantity: ').$product->fresh()->quantity);
        $this->reset(['product_id', 'adjustment', 'reason', 'reference_number', 'notes']);
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::Adjustment);
    }

    public function getSelectedSkuProperty(): ?string
    {
        return Product::whereKey($this->product_id)->value('sku');
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
