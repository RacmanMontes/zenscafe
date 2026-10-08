<?php

namespace App\Livewire\Categories;

use App\Actions\Category\ArchiveCategory;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Categories')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 15;

    public bool $showArchiveModal = false;

    public ?int $categoryToArchive = null;

    public bool $showCreateModal = false;

    public bool $showEditModal = false;

    public ?int $editingCategoryId = null;

    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    public function openEditModal(int $categoryId): void
    {
        $this->editingCategoryId = $categoryId;
        $this->showEditModal = true;
    }

    #[On('categoryCreated')]
    public function categoryCreated(): void
    {
        $this->showCreateModal = false;
    }

    #[On('cancelCategoryCreate')]
    public function cancelCategoryCreate(): void
    {
        $this->showCreateModal = false;
    }

    #[On('categoryUpdated')]
    public function categoryUpdated(): void
    {
        $this->showEditModal = false;
        $this->editingCategoryId = null;
    }

    #[On('cancelCategoryEdit')]
    public function cancelCategoryEdit(): void
    {
        $this->showEditModal = false;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function confirmArchive(int $categoryId): void
    {
        $this->authorize('delete', Category::findOrFail($categoryId));

        $this->categoryToArchive = $categoryId;
        $this->showArchiveModal = true;
    }

    public function archive(ArchiveCategory $action): void
    {
        $category = Category::findOrFail($this->categoryToArchive);

        $this->authorize('delete', $category);

        try {
            $action->execute($category, request());
        } catch (\DomainException $e) {
            $this->dispatch('zenscafe-toast', variant: 'danger', title: __('Error'), text: __($e->getMessage()));
            $this->showArchiveModal = false;

            return;
        }

        $this->showArchiveModal = false;
        $this->categoryToArchive = null;

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Category archived successfully.'));
    }

    public function render()
    {
        $query = Category::active()->withCount('products')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest();

        return view('livewire.categories.index', [
            'categories' => $query->paginate($this->perPage),
            'editingCategory' => $this->editingCategoryId ? Category::find($this->editingCategoryId) : null,
        ]);
    }
}
