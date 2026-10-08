<?php

use App\Http\Controllers\InventoryReportExportController;
use App\Livewire\Audit\Index as AuditIndex;
use App\Livewire\Categories\Index as CategoryIndex;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\History\Index as HistoryIndex;
use App\Livewire\Products\Index as ProductIndex;
use App\Livewire\Products\Show as ProductShow;
use App\Livewire\Reports\CurrentInventory;
use App\Livewire\Reports\Index as ReportIndex;
use App\Livewire\Reports\LowStock;
use App\Livewire\Reports\StockMovement;
use App\Livewire\Stock\Adjustment;
use App\Livewire\Stock\StockIn;
use App\Livewire\Stock\StockOut;
use App\Livewire\Suppliers\Index as SupplierIndex;
use App\Livewire\Suppliers\Show as SupplierShow;
use App\Livewire\Users\Create as UserCreate;
use App\Livewire\Users\Edit as UserEdit;
use App\Livewire\Users\Index as UserIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardIndex::class)->name('dashboard');

    // Products
    Route::get('products', ProductIndex::class)->name('products.index');
    Route::get('products/{product}', ProductShow::class)->name('products.show');

    // Categories
    Route::get('categories', CategoryIndex::class)->name('categories.index');

    // Suppliers
    Route::get('suppliers', SupplierIndex::class)->name('suppliers.index');
    Route::get('suppliers/{supplier}', SupplierShow::class)->name('suppliers.show');

    // Stock
    Route::get('stock-in', StockIn::class)->name('stock-in');
    Route::get('stock-out', StockOut::class)->name('stock-out');

    // Inventory History
    Route::get('inventory-history', HistoryIndex::class)->name('inventory-history');

    // Reports
    Route::get('reports', ReportIndex::class)->name('reports');
    Route::get('reports/current-inventory', CurrentInventory::class)->name('reports.current-inventory');
    Route::get('reports/current-inventory/export/pdf', [InventoryReportExportController::class, 'pdf'])->name('reports.current-inventory.export-pdf');
    Route::get('reports/current-inventory/export/excel', [InventoryReportExportController::class, 'excel'])->name('reports.current-inventory.export-excel');
    Route::get('reports/current-inventory/export/word', [InventoryReportExportController::class, 'word'])->name('reports.current-inventory.export-word');
    Route::get('reports/low-stock', LowStock::class)->name('reports.low-stock');
    Route::get('reports/stock-movement', StockMovement::class)->name('reports.stock-movement');

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        Route::get('stock/adjustment', Adjustment::class)->name('stock-adjustment');

        // User Management
        Route::get('users', UserIndex::class)->name('users.index');
        Route::get('users/create', UserCreate::class)->name('users.create');
        Route::get('users/{user}/edit', UserEdit::class)->name('users.edit');

        // Audit Logs
        Route::get('audit-logs', AuditIndex::class)->name('audit-logs');
    });
});

require __DIR__.'/settings.php';
