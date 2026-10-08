<?php

namespace App\Livewire\Stock;

use App\Actions\Inventory\StockInProduct;
use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Stock In')]
class StockIn extends Component
{
    public ?int $product_id = null;

    public int $quantity = 1;

    public ?int $supplier_id = null;

    public string $date = '';

    public ?string $reference_number = null;

    public ?string $notes = null;

    public string $search = '';

    protected function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::StockIn);
    }

    public function getSelectedSkuProperty(): ?string
    {
        return Product::whereKey($this->product_id)->value('sku');
    }

    public function submit(StockInProduct $action): void
    {
        $validated = $this->validate();

        $product = Product::where('status', 'active')->findOrFail($validated['product_id']);

        $action->execute(
            product: $product,
            quantity: $validated['quantity'],
            supplierId: $validated['supplier_id'] ?? null,
            referenceNumber: $validated['reference_number'] ?? null,
            notes: $validated['notes'] ?? null,
            transactedAt: Carbon::parse($validated['date']),
            request: request(),
        );

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Stock in recorded successfully. New quantity: ').$product->fresh()->quantity);
        $this->reset(['product_id', 'quantity', 'supplier_id', 'reference_number', 'notes']);
        $this->date = now()->format('Y-m-d');
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::StockIn);
    }

    public function getProductsProperty()
    {
        return Product::where('status', 'active')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.stock.stock-in', [
            'products' => $this->products,
            'suppliers' => Supplier::active()->orderBy('name')->get(),
        ]);
    }
}
