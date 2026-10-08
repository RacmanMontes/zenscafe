<?php

namespace App\Livewire\Stock;

use App\Actions\Inventory\StockOutProduct;
use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Stock Out')]
class StockOut extends Component
{
    public ?int $product_id = null;

    public int $quantity = 1;

    public ?string $reason = null;

    public string $date = '';

    public ?string $reference_number = null;

    public ?string $notes = null;

    public string $scan = '';

    protected function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'reference_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::StockOut);
    }

    public function getSelectedSkuProperty(): ?string
    {
        return Product::whereKey($this->product_id)->value('sku');
    }

    public function handleScan(): void
    {
        $product = Product::resolveByScan($this->scan);

        if ($product === null) {
            $this->addError('scan', __('No active product matches that code.'));

            return;
        }

        $this->resetErrorBag('scan');
        $this->scan = '';
        $this->product_id = $product->id;
        $this->js("document.getElementById('stock-out-quantity')?.focus()");
    }

    public function submit(StockOutProduct $action): void
    {
        $validated = $this->validate();

        $product = Product::where('status', 'active')->findOrFail($validated['product_id']);

        $action->execute(
            product: $product,
            quantity: $validated['quantity'],
            reason: $validated['reason'] ?? null,
            referenceNumber: $validated['reference_number'] ?? null,
            notes: $validated['notes'] ?? null,
            transactedAt: Carbon::parse($validated['date']),
            request: request(),
        );

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Stock out recorded successfully. New quantity: ').$product->fresh()->quantity);
        $this->reset(['product_id', 'quantity', 'reason', 'reference_number', 'notes']);
        $this->date = now()->format('Y-m-d');
        $this->reference_number = InventoryTransaction::generateReferenceNumber(TransactionType::StockOut);
    }

    public function getProductsProperty()
    {
        return Product::where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        return view('livewire.stock.stock-out', [
            'products' => $this->products,
        ]);
    }
}
