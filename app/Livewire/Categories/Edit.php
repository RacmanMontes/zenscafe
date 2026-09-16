<?php

namespace App\Livewire\Categories;

use App\Actions\Category\UpdateCategory;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Category')]
class Edit extends Component
{
    public Category $category;

    public string $name = '';

    public ?string $description = null;

    public function mount(Category $category): void
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$this->category->id],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(UpdateCategory $action): void
    {
        $validated = $this->validate();

        $action->execute($this->category, $validated, request());

        session()->flash('success', __('Category updated successfully.'));
        $this->redirectRoute('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
