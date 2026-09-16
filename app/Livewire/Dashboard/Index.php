<?php

namespace App\Livewire\Dashboard;

use App\Models\Category;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.index', [
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalSuppliers' => Supplier::count(),
            'lowStockCount' => Product::query()->where('quantity', '>', 0)
                ->whereColumn('quantity', '<=', 'min_stock')
                ->count(),
            'outOfStockCount' => Product::where('quantity', '<=', 0)->count(),
            'totalUsers' => User::count(),
            'recentTransactions' => InventoryTransaction::with(['product', 'user'])
                ->latest()
                ->limit(10)
                ->get(),
            'recentProducts' => Product::with(['category', 'supplier'])
                ->latest()
                ->limit(5)
                ->get(),
            'stockMovements' => InventoryTransaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN type = "stock_in" THEN quantity ELSE 0 END) as stock_in_total'),
                DB::raw('SUM(CASE WHEN type = "stock_out" THEN quantity ELSE 0 END) as stock_out_total'),
            )
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date')
                ->get(),
            'categoryDistribution' => Product::select('category_id', DB::raw('COUNT(*) as count'))
                ->groupBy('category_id')
                ->with('category:id,name')
                ->get(),
        ]);
    }
}
