<?php

namespace App\Livewire\Suppliers;

use App\Actions\Supplier\ArchiveSupplier;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Suppliers')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 15;

    public bool $showArchiveModal = false;

    public ?int $supplierToArchive = null;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmArchive(int $supplierId): void
    {
        $this->authorize('delete', Supplier::findOrFail($supplierId));

        $this->supplierToArchive = $supplierId;
        $this->showArchiveModal = true;
    }

    public function archive(ArchiveSupplier $action): void
    {
        $supplier = Supplier::findOrFail($this->supplierToArchive);

        $this->authorize('delete', $supplier);

        try {
            $action->execute($supplier, request());
        } catch (\DomainException $e) {
            session()->flash('error', __($e->getMessage()));
            $this->showArchiveModal = false;

            return;
        }

        $this->showArchiveModal = false;
        $this->supplierToArchive = null;

        session()->flash('success', __('Supplier archived successfully.'));
    }

    public function render()
    {
        $query = Supplier::withCount('products')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('contact_person', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->latest();

        return view('livewire.suppliers.index', [
            'suppliers' => $query->paginate($this->perPage),
        ]);
    }
}
