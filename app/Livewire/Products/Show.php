<?php

namespace App\Livewire\Products;

use App\Actions\Product\ArchiveProduct;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details')]
class Show extends Component
{
    public Product $product;

    public bool $showArchiveModal = false;

    public function mount(Product $product): void
    {
        $this->product = $product->load(['category', 'supplier', 'transactions.user']);
    }

    public function archive(ArchiveProduct $action): void
    {
        $this->authorize('delete', $this->product);

        $action->execute($this->product, request());

        $this->showArchiveModal = false;

        session()->flash('success', __('Product archived successfully.'));
        $this->redirectRoute('products.index');
    }

    public function render()
    {
        return view('livewire.products.show');
    }
}
