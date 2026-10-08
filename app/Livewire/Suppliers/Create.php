<?php

namespace App\Livewire\Suppliers;

use App\Actions\Supplier\CreateSupplier;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    public ?string $contact_person = null;

    public ?string $email = null;

    public ?string $phone = null;

    public ?string $address = null;

    public ?string $notes = null;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:suppliers,name'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function save(CreateSupplier $action): void
    {
        $validated = $this->validate();

        $action->execute($validated, request());

        $this->reset();

        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __('Supplier created successfully.'));
        $this->dispatch('supplierCreated')->to(Index::class);
    }

    public function cancelCreate(): void
    {
        $this->dispatch('cancelSupplierCreate')->to(Index::class);
    }

    public function render()
    {
        return view('livewire.suppliers.create');
    }
}
