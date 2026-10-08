<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CurrentInventoryExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        public Collection $products,
        public int $totalItems,
        public int $totalQuantity,
        public float $totalValue,
    ) {}

    /**
     * @return Collection<int, Product>
     */
    public function collection(): Collection
    {
        return $this->products;
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            __('Item'),
            __('SKU'),
            __('Category'),
            __('Supplier'),
            __('Unit'),
            __('Quantity'),
            __('Min Stock'),
            __('Unit Cost ($)'),
            __('Value ($)'),
            __('Status'),
        ];
    }

    /**
     * @param  Product  $product
     * @return array<int, string|int|null>
     */
    public function map($product): array
    {
        $value = $product->cost_per_unit !== null ? $product->quantity * $product->cost_per_unit : null;

        $status = match (true) {
            $product->isOutOfStock() => __('Out of Stock'),
            $product->isLowStock() => __('Low Stock'),
            default => __('In Stock'),
        };

        return [
            $product->name,
            $product->sku,
            $product->category?->name ?? '—',
            $product->supplier?->name ?? '—',
            $product->unit,
            $product->quantity,
            $product->min_stock,
            $product->cost_per_unit !== null ? number_format($product->cost_per_unit, 2) : '—',
            $value !== null ? number_format($value, 2) : '—',
            $status,
        ];
    }
}
