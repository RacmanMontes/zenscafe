<?php

namespace App\Livewire\Suppliers;

use App\Actions\Supplier\UpdateSupplier;
use App\Models\Supplier;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Supplier')]
class Edit extends Component
{
    public Supplier $supplier;

    public string $name = '';

    public ?string $contact_person = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $address = null;

    public ?string $notes = null;

    public function mount(Supplier $supplier): void
    {
        $this->supplier = $supplier;
        $this->fill($supplier->only(['name', 'contact_person', 'email', 'phone', 'address', 'notes']));
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:suppliers,name,'.$this->supplier->id],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(UpdateSupplier $action): void
    {
        $validated = $this->validate();

        $action->execute($this->supplier, $validated, request());

        session()->flash('success', __('Supplier updated successfully.'));
        $this->redirectRoute('suppliers.index');
    }

    public function render()
    {
        return view('livewire.suppliers.edit');
    }
}
