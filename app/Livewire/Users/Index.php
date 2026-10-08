<?php

namespace App\Livewire\Users;

use App\Actions\User\ToggleUserStatus;
use App\Enums\UserRole;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Users')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public int $perPage = 15;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(User $user, ToggleUserStatus $action): void
    {
        if ($user->id === auth()->id()) {
            $this->dispatch('zenscafe-toast', variant: 'danger', title: __('Error'), text: __('You cannot deactivate your own account.'));

            return;
        }

        $action->execute($user, request());

        $status = $user->fresh()->email_verified_at ? 'activated' : 'deactivated';
        $this->dispatch('zenscafe-toast', variant: 'success', title: __('Success'), text: __("User {$status} successfully."));
    }

    public function render()
    {
        $query = User::withCount('auditLogs')
            ->when($this->search, fn ($q) => $q->where(function ($sub) {
                $sub->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%");
            }))
            ->latest();

        return view('livewire.users.index', [
            'users' => $query->paginate($this->perPage),
            'roles' => UserRole::cases(),
        ]);
    }
}
