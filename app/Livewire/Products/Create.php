<?php

namespace App\Livewire\Products;

use App\Actions\Product\CreateProduct;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\Component;

class Create extends Component
{
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

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'unit' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'max_stock' => ['nullable', 'integer', 'min:0', 'gte:quantity'],
            'cost_per_unit' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,archived'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'sku.unique' => 'This SKU already exists. Please use a unique SKU.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'supplier_id.exists' => 'The selected supplier does not exist.',
        ];
    }

    public function save(CreateProduct $action): void
    {
        $validated = $this->validate();

        $action->execute($validated, request());

        $this->reset();

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Product created successfully.'));
        $this->dispatch('productCreated')->to(Index::class);
    }

    public function cancelCreate(): void
    {
        $this->dispatch('cancelProductCreate')->to(Index::class);
    }

    public function render()
    {
        return view('livewire.products.create', [
            'categories' => Category::active()->orderBy('name')->get(),
            'suppliers' => Supplier::active()->orderBy('name')->get(),
        ]);
    }
}
