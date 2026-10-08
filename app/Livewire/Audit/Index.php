<?php

namespace App\Livewire\Audit;

use App\Models\AuditLog;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Audit Logs')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $eventFilter = '';

    public string $dateFrom = '';

    public string $dateTo = '';

    public int $perPage = 25;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedEventFilter(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = AuditLog::with('user')
            ->when($this->search, fn ($q) => $q->where(function ($sub) {
                $sub->where('event', 'like', "%{$this->search}%")
                    ->orWhere('auditable_type', 'like', "%{$this->search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$this->search}%"));
            }))
            ->when($this->eventFilter, fn ($q) => $q->where('event', $this->eventFilter))
            ->when($this->dateFrom, fn ($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn ($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest();

        return view('livewire.audit.index', [
            'logs' => $query->paginate($this->perPage),
            'events' => AuditLog::query()->distinct()->orderBy('event')->pluck('event'),
        ]);
    }
}
