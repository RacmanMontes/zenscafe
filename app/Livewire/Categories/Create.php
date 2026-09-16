<?php

namespace App\Livewire\Categories;

use App\Actions\Category\CreateCategory;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Add Category')]
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

        session()->flash('success', __('Category created successfully.'));
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}
