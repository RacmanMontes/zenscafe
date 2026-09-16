<?php

namespace App\Livewire\Reports;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Low Stock Report')]
class LowStock extends Component
{
    public function render()
    {
        $lowStockProducts = Product::with(['category', 'supplier'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->whereColumn('quantity', '<=', 'min_stock')
            ->orderBy('quantity')
            ->get();

        $outOfStockProducts = Product::with(['category', 'supplier'])
            ->where('status', 'active')
            ->where('quantity', '<=', 0)
            ->orderBy('name')
            ->get();

        return view('livewire.reports.low-stock', [
            'lowStockProducts' => $lowStockProducts,
            'outOfStockProducts' => $outOfStockProducts,
        ]);
    }
}
