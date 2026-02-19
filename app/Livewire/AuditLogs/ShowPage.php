<?php

namespace App\Livewire\AuditLogs;

use App\Models\AuditLog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ShowPage extends Component
{
    use AuthorizesRequests;

    public AuditLog $auditLog;

    public function mount(AuditLog $auditLog): void
    {
        $this->authorize('view', $auditLog);
        $this->auditLog->load(['user', 'auditable']);
    }

    public function render()
    {
        return view('livewire.audit-logs.show-page');
    }
}
