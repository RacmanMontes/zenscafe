<?php

namespace App\Livewire\Suppliers;

use App\Models\InventoryTransaction;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Supplier Details')]
class Show extends Component
{
    use WithPagination;

    public Supplier $supplier;

    public string $search = '';

    public int $perPage = 15;

    public function mount(Supplier $supplier): void
    {
        abort_unless($supplier->status === Supplier::STATUS_ACTIVE, 404);

        $this->supplier = $supplier->load('products.category');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = InventoryTransaction::with(['product', 'user'])
            ->where('supplier_id', $this->supplier->id)
            ->when($this->search, fn ($q) => $q->whereHas('product', fn ($sub) => $sub
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('sku', 'like', "%{$this->search}%")))
            ->orderByDesc('transacted_at')
            ->paginate($this->perPage);

        return view('livewire.suppliers.show', [
            'transactions' => $transactions,
            'products' => $this->supplier->products,
        ]);
    }
}
