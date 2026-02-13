<?php

namespace App\Livewire\AuditLogs;

use App\Models\AuditLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class TablePage extends Component
{
    use WithPagination, AuthorizesRequests;

    public string $search = '';
    public string $eventFilter = '';
    public string $auditableTypeFilter = '';
    public string $userFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'eventFilter' => ['except' => ''],
        'auditableTypeFilter' => ['except' => ''],
        'userFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->authorize('viewAny', AuditLog::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingEventFilter(): void
    {
        $this->resetPage();
    }

    public function updatingAuditableTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatingUserFilter(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $auditLogs = AuditLog::query()
            ->with(['user', 'auditable'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('event', 'like', "%{$this->search}%")
                        ->orWhere('auditable_type', 'like', "%{$this->search}%")
                        ->orWhere('message', 'like', "%{$this->search}%")
                        ->orWhere('ip_address', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q) {
                            $q->where('first_name', 'like', "%{$this->search}%")
                                ->orWhere('last_name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->eventFilter, function ($query) {
                $query->where('event', $this->eventFilter);
            })
            ->when($this->auditableTypeFilter, function ($query) {
                $query->where('auditable_type', $this->auditableTypeFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->latest()
            ->paginate(15);

        $events = AuditLog::select('event')
            ->distinct()
            ->orderBy('event')
            ->pluck('event');

        $auditableTypes = AuditLog::select('auditable_type')
            ->distinct()
            ->orderBy('auditable_type')
            ->get()
            ->pluck('auditable_type')
            ->map(fn($type) => [
                'value' => $type,
                'label' => class_basename($type)
            ]);

        $users = \App\Models\User::select('id', 'first_name', 'last_name', 'email')
            ->orderBy('first_name')
            ->get();

        return view('livewire.audit-logs.table-page', [
            'auditLogs' => $auditLogs,
            'events' => $events,
            'auditableTypes' => $auditableTypes,
            'users' => $users,
        ]);
    }
}