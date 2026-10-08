<?php

namespace App\Http\Controllers;

use App\Exports\CurrentInventoryExport;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class InventoryReportExportController extends Controller
{
    /**
     * Download the current inventory report as a PDF document.
     */
    public function pdf(Request $request)
    {
        $report = $this->reportData($request);

        return Pdf::loadView('exports.current-inventory-pdf', $report)
            ->setPaper('a4', 'landscape')
            ->download('current-inventory.pdf');
    }

    /**
     * Download the current inventory report as an Excel spreadsheet.
     */
    public function excel(Request $request)
    {
        $report = $this->reportData($request);

        return Excel::download(
            new CurrentInventoryExport(
                products: $report['products'],
                totalItems: $report['totalItems'],
                totalQuantity: $report['totalQuantity'],
                totalValue: $report['totalValue'],
            ),
            'current-inventory.xlsx',
        );
    }

    /**
     * Download the current inventory report as a Word document.
     */
    public function word(Request $request)
    {
        $report = $this->reportData($request);

        $directory = $this->ensureDirectory(sys_get_temp_dir().'/inventory-report');

        $phpWord = new PhpWord;

        $section = $phpWord->addSection([
            'orientation' => 'landscape',
            'marginTop' => 720,
            'marginBottom' => 720,
            'marginLeft' => 720,
            'marginRight' => 720,
        ]);

        $section->addText(
            "Zen's Cafe - Current Inventory Report",
            ['bold' => true, 'size' => 16],
        );
        $section->addText(
            'Generated on '.now()->format('F d, Y \a\t g:i A').'  |  Total Items: '.$report['totalItems'].'  |  Total Quantity: '.$report['totalQuantity'].'  |  Total Value: $'.number_format($report['totalValue'], 2),
            ['italic' => true, 'size' => 10],
        );
        $section->addTextBreak();

        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 60,
        ]);

        $table->addRow();
        foreach ($this->wordHeadings() as $heading) {
            $table->addCell(900)->addText($heading, ['bold' => true, 'size' => 9]);
        }

        foreach ($report['products'] as $product) {
            $table->addRow();

            foreach ($this->wordRow($product) as $cell) {
                $table->addCell(900)->addText((string) $cell, ['size' => 9]);
            }
        }

        $section->addTextBreak();
        $section->addText(
            "Prepared by ZEN'S CAFE Web-Based Inventory Management System",
            ['italic' => true, 'size' => 9],
        );

        $filePath = $directory.'/current-inventory-'.uniqid().'.docx';

        IOFactory::createWriter($phpWord, 'Word2007')->save($filePath);

        return response()->download($filePath, 'current-inventory.docx')->deleteFileAfterSend(true);
    }

    /**
     * Build the filtered product list and report totals, matching the Livewire page.
     *
     * @return array{products: Collection<int, Product>, totalItems: int, totalQuantity: int, totalValue: float}
     */
    private function reportData(Request $request): array
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->query('search'), fn ($query) => $query->where('name', 'like', "%{$request->query('search')}%"))
            ->when($request->query('category_id'), fn ($query) => $query->where('category_id', $request->query('category_id')))
            ->when($request->query('supplier_id'), fn ($query) => $query->where('supplier_id', $request->query('supplier_id')))
            ->orderBy('name')
            ->get();

        return [
            'products' => $products,
            'totalItems' => $products->count(),
            'totalQuantity' => $products->sum('quantity'),
            'totalValue' => $products->filter(fn ($product) => $product->cost_per_unit !== null)
                ->sum(fn ($product) => $product->quantity * $product->cost_per_unit),
        ];
    }

    /**
     * @return array<int, string>
     */
    private function wordHeadings(): array
    {
        return [
            'Item', 'SKU', 'Category', 'Supplier', 'Unit', 'Qty', 'Min', 'Unit Cost ($)', 'Value ($)', 'Status',
        ];
    }

    /**
     * @return array<int, string>
     */
    private function wordRow(Product $product): array
    {
        $value = $product->cost_per_unit !== null ? $product->quantity * $product->cost_per_unit : null;

        $status = match (true) {
            $product->isOutOfStock() => 'Out of Stock',
            $product->isLowStock() => 'Low Stock',
            default => 'In Stock',
        };

        return [
            $product->name,
            $product->sku,
            $product->category?->name ?? '—',
            $product->supplier?->name ?? '—',
            $product->unit,
            (string) $product->quantity,
            (string) $product->min_stock,
            $product->cost_per_unit !== null ? number_format($product->cost_per_unit, 2) : '—',
            $value !== null ? number_format($value, 2) : '—',
            $status,
        ];
    }

    private function ensureDirectory(string $path): string
    {
        if (! is_dir($path)) {
            mkdir($path, 0775, true);
        }

        return $path;
    }
}
