<?php

namespace App\Livewire\Reports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Current Inventory Report')]
class CurrentInventory extends Component
{
    public string $search = '';

    public ?int $category_id = null;

    public ?int $supplier_id = null;

    public function render()
    {
        $query = Product::with(['category', 'supplier'])
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->category_id, fn ($q) => $q->where('category_id', $this->category_id))
            ->when($this->supplier_id, fn ($q) => $q->where('supplier_id', $this->supplier_id))
            ->orderBy('name');

        $products = $query->get();

        return view('livewire.reports.current-inventory', [
            'products' => $products,
            'categories' => Category::active()->orderBy('name')->get(),
            'suppliers' => Supplier::active()->orderBy('name')->get(),
            'totalItems' => $products->count(),
            'totalQuantity' => $products->sum('quantity'),
            'totalValue' => $products->filter(fn ($p) => $p->cost_per_unit !== null)
                ->sum(fn ($p) => $p->quantity * $p->cost_per_unit),
        ]);
    }
}
