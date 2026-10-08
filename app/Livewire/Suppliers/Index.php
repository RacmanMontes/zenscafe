<?php

namespace App\Livewire\Suppliers;

use App\Actions\Supplier\ArchiveSupplier;
use App\Models\Supplier;
use Livewire\Attributes\On;
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

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public ?int $editingSupplierId = null;

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function openEditModal(int $supplierId): void
    {
        $this->editingSupplierId = $supplierId;
        $this->showEditModal = true;
    }

    #[On('supplierCreated')]
    public function supplierCreated(): void
    {
        $this->showCreateModal = false;
    }

    #[On('cancelSupplierCreate')]
    public function cancelSupplierCreate(): void
    {
        $this->showCreateModal = false;
    }

    #[On('supplierUpdated')]
    public function supplierUpdated(): void
    {
        $this->showEditModal = false;
        $this->editingSupplierId = null;
    }

    #[On('cancelSupplierEdit')]
    public function cancelSupplierEdit(): void
    {
        $this->showEditModal = false;
    }

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
            $this->dispatch('zenscafe-toast', variant: 'danger', title: __('Error'), text: __($e->getMessage()));
            $this->showArchiveModal = false;

            return;
        }

        $this->showArchiveModal = false;
        $this->supplierToArchive = null;

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Supplier archived successfully.'));
    }

    public function render()
    {
        $query = Supplier::active()->withCount('products')
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
            'editingSupplier' => $this->editingSupplierId ? Supplier::find($this->editingSupplierId) : null,
        ]);
    }
}
