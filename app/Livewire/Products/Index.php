<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $categoryFilter = '';

    public string $supplierFilter = '';

    public string $statusFilter = '';

    public string $stockFilter = '';

    public int $perPage = 15;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSupplierFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStockFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['category', 'supplier'])
            ->when($this->search, fn ($q) => $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('sku', 'like', "%{$this->search}%");
            }))
            ->when($this->categoryFilter, fn ($q) => $q->where('category_id', $this->categoryFilter))
            ->when($this->supplierFilter, fn ($q) => $q->where('supplier_id', $this->supplierFilter))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->stockFilter === 'low_stock', fn ($q) => $q->lowStock())
            ->when($this->stockFilter === 'out_of_stock', fn ($q) => $q->outOfStock())
            ->when($this->stockFilter === 'in_stock', fn ($q) => $q->inStock())
            ->latest();

        return view('livewire.products.index', [
            'products' => $query->paginate($this->perPage),
            'categories' => Category::active()->orderBy('name')->get(),
            'suppliers' => Supplier::active()->orderBy('name')->get(),
        ]);
    }
}
