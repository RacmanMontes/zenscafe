<?php

namespace App\Livewire\Reports;

use App\Models\InventoryTransaction;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Stock Movement Report')]
class StockMovement extends Component
{
    public string $dateFrom = '';

    public string $dateTo = '';

    public ?int $product_id = null;

    public string $type = '';

    public function mount(): void
    {
        $this->dateFrom = now()->subDays(30)->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    public function render()
    {
        $query = InventoryTransaction::with(['product', 'user'])
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->when($this->product_id, fn ($q) => $q->where('product_id', $this->product_id))
            ->when($this->type, fn ($q) => $q->where('type', $this->type))
            ->latest();

        $transactions = $query->get();

        return view('livewire.reports.stock-movement', [
            'transactions' => $transactions,
            'products' => Product::orderBy('name')->get(),
            'summary' => [
                'stock_in' => $transactions->where('type', 'stock_in')->sum('quantity'),
                'stock_out' => $transactions->where('type', 'stock_out')->sum('quantity'),
                'adjustments' => $transactions->where('type', 'adjustment')->count(),
                'total' => $transactions->count(),
            ],
        ]);
    }
}
