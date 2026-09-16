<?php

namespace App\Livewire\Categories;

use App\Actions\Category\ArchiveCategory;
use App\Models\Category;
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
            session()->flash('error', __($e->getMessage()));
            $this->showArchiveModal = false;

            return;
        }

        $this->showArchiveModal = false;
        $this->categoryToArchive = null;

        session()->flash('success', __('Category archived successfully.'));
    }

    public function render()
    {
        $query = Category::withCount('products')
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->latest();

        return view('livewire.categories.index', [
            'categories' => $query->paginate($this->perPage),
        ]);
    }
}
