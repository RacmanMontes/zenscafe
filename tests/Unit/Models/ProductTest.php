<?php

use App\Models\Product;

it('singularizes pcs when the quantity is exactly one', function (int $quantity, string $expected) {
    $product = new Product(['unit' => 'pcs', 'quantity' => $quantity]);

    expect($product->unitLabel())->toBe($expected);
})->with([
    [1, 'pc'],
    [2, 'pcs'],
    [0, 'pcs'],
]);

it('leaves other units unchanged', function () {
    $product = new Product(['unit' => 'kg', 'quantity' => 1]);

    expect($product->unitLabel())->toBe('kg');
});
