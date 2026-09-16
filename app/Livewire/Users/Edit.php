<?php

namespace App\Livewire\Users;

use App\Actions\User\UpdateUser;
use App\Enums\UserRole;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit User')]
class Edit extends Component
{
    public User $user;

    public string $name = '';

    public string $email = '';

    public ?string $password = null;

    public ?string $password_confirmation = null;

    public string $role = 'staff';

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role->value;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:'.implode(',', UserRole::values())],
        ];
    }

    public function save(UpdateUser $action): void
    {
        $validated = $this->validate();

        if ($validated['password'] === null) {
            unset($validated['password']);
            unset($validated['password_confirmation']);
        }

        $action->execute($this->user, $validated, request());

        session()->flash('success', __('User updated successfully.'));
        $this->redirectRoute('users.index');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
