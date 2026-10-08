<?php

namespace App\Livewire\Categories;

use App\Actions\Category\CreateCategory;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public ?string $description = null;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(CreateCategory $action): void
    {
        $validated = $this->validate();

        $action->execute($validated, request());

        $this->reset();

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Category created successfully.'));
        $this->dispatch('categoryCreated')->to(Index::class);
    }

    public function cancelCreate(): void
    {
        $this->dispatch('cancelCategoryCreate')->to(Index::class);
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
