<?php

use App\Livewire\Audit\Index as AuditIndex;
use App\Livewire\Reports\StockMovement;
use App\Livewire\Stock\Adjustment;
use App\Livewire\Stock\StockIn;
use App\Livewire\Stock\StockOut;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('selects bubble an empty placeholder option instead of pre-selecting the first product', function (string $component, string $selectName) {
    $this->actingAs(User::factory()->admin()->create(['email_verified_at' => now()]));
    Product::factory()->create(['name' => 'Alpha Beans']);

    $html = Livewire::test($component)->html();

    preg_match('/<select[^>]*name="'.$selectName.'".*?<\/select>/s', $html, $matches);
    $select = $matches[0] ?? '';

    expect($select)->not->toBeEmpty();

    preg_match('/<option([^>]*)>/', $select, $option);

    expect($option[1] ?? '')
        ->toContain('value=""')
        ->not->toContain('disabled');
})->with([
    'stock in' => [StockIn::class, 'product_id'],
    'stock out' => [StockOut::class, 'product_id'],
    'adjustment' => [Adjustment::class, 'product_id'],
    'stock movement report' => [StockMovement::class, 'product_id'],
    'audit event filter' => [AuditIndex::class, 'eventFilter'],
]);
