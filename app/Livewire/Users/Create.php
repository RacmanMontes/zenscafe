<?php

namespace App\Livewire\Users;

use App\Actions\User\CreateUser;
use App\Enums\UserRole;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Add User')]
class Create extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'staff';

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:'.implode(',', UserRole::values())],
        ];
    }

    public function save(CreateUser $action): void
    {
        $validated = $this->validate();

        $action->execute($validated, request());

        session()->flash('success', __('User created successfully.'));
        $this->redirectRoute('users.index');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
