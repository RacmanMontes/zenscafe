<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <style>
            * { font-family: 'DejaVu Sans', sans-serif; }
            body { color: #1c1917; font-size: 10px; line-height: 1.35; }
            .header { border-bottom: 2px solid #1c1917; padding-bottom: 6px; margin-bottom: 8px; }
            .header h1 { font-size: 17px; margin: 0 0 2px; text-transform: uppercase; }
            .header p { margin: 0; color: #57534e; font-size: 9.5px; }
            .summary { margin: 8px 0 14px; font-size: 11px; }
            .summary strong { display: inline-block; margin-inline-end: 16px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #d6d3d1; padding: 4px 6px; text-align: left; vertical-align: top; }
            th { background: #f5f5f4; font-size: 9.5px; text-transform: uppercase; }
            td { font-size: 9.5px; }
            .right { text-align: right; }
            .mono { font-family: 'Courier New', monospace; font-size: 9px; color: #57534e; }
            .empty { text-align: center; padding: 24px 0; color: #78716c; }
            .footer { margin-top: 14px; padding-top: 6px; border-top: 1px solid #d6d3d1; color: #78716c; font-size: 9px; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Zen's Cafe - Current Inventory Report</h1>
            <p>
                Generated on {{ now()->format('F d, Y \a\t g:i A') }}
                @if(request()->query('search'))
                    &middot; Search: "{{ request()->query('search') }}"
                @endif
            </p>
        </div>

        <div class="summary">
            <strong>Total Items: {{ $totalItems }}</strong>
            <strong>Total Quantity: {{ $totalQuantity }}</strong>
            <strong>Total Value: ${{ number_format($totalValue, 2) }}</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Unit</th>
                    <th class="right">Qty</th>
                    <th class="right">Min</th>
                    <th class="right">Unit Cost</th>
                    <th class="right">Value</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td class="mono">{{ $product->sku }}</td>
                        <td>{{ $product->category?->name ?? '—' }}</td>
                        <td>{{ $product->supplier?->name ?? '—' }}</td>
                        <td>{{ $product->unit }}</td>
                        <td class="right">{{ $product->quantity }}</td>
                        <td class="right">{{ $product->min_stock }}</td>
                        <td class="right">{{ $product->cost_per_unit !== null ? '$'.number_format($product->cost_per_unit, 2) : '—' }}</td>
                        <td class="right">{{ $product->cost_per_unit !== null ? '$'.number_format($product->quantity * $product->cost_per_unit, 2) : '—' }}</td>
                        <td>
                            @if($product->isOutOfStock())
                                Out of Stock
                            @elseif($product->isLowStock())
                                Low Stock
                            @else
                                In Stock
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="empty">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            Prepared by ZEN'S CAFE Web-Based Inventory Management System.
        </div>
    </body>
</html>