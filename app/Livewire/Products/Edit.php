<?php

namespace App\Livewire\Products;

use App\Actions\Product\UpdateProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Product')]
class Edit extends Component
{
    public Product $product;

    public string $name = '';

    public string $sku = '';

    public ?int $category_id = null;

    public ?int $supplier_id = null;

    public string $unit = 'pcs';

    public int $quantity = 0;

    public int $min_stock = 0;

    public ?int $max_stock = null;

    public ?float $cost_per_unit = null;

    public string $status = 'active';

    public ?string $description = null;

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->fill($product->only([
            'name', 'sku', 'category_id', 'supplier_id', 'unit',
            'quantity', 'min_stock', 'max_stock', 'cost_per_unit',
            'status', 'description',
        ]));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku,'.$this->product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'unit' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'max_stock' => ['nullable', 'integer', 'min:0'],
            'cost_per_unit' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,archived'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(UpdateProduct $action): void
    {
        $validated = $this->validate();

        $action->execute($this->product, $validated, request());

        session()->flash('success', __('Product updated successfully.'));
        $this->redirectRoute('products.show', $this->product);
    }

    public function render()
    {
        return view('livewire.products.edit', [
            'categories' => Category::active()->orderBy('name')->get(),
            'suppliers' => Supplier::active()->orderBy('name')->get(),
        ]);
    }
}
