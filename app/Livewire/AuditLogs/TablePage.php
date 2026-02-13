<?php

namespace App\Livewire\AuditLogs;

use App\Models\AuditLog;
use App\Traits\WithRelationshipSorting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

#[Layout('components.layouts.app')]
class TablePage extends Component
{
    use WithPagination, AuthorizesRequests, WithRelationshipSorting;

    #[Url(except: '')]
    public string $search = '';
    
    #[Url(except: '')]
    public string $eventFilter = '';
    
    #[Url(except: '')]
    public string $auditableTypeFilter = '';
    
    #[Url(except: '')]
    public string $dateFilter = '';
    
    #[Url(except: '')]
    public string $dateFrom = '';
    
    #[Url(except: '')]
    public string $dateTo = '';
    
    #[Url(except: '')]
    public string $timeFrom = '';
    
    #[Url(except: '')]
    public string $timeTo = '';
    
    public bool $showTimeFilters = false;

    protected array $sortableColumns = [
        'id',
        'event',
        'auditable_type',
        'created_at',
        'user_name', 
    ];

    protected array $relationshipSorts = [
        'user_name' => ['user', 'first_name'],
    ];

    public function mount(): void
    {
        $this->authorize('viewAny', AuditLog::class);
        
        $this->sortField = $this->sortField ?: 'created_at';
        $this->sortDirection = $this->sortDirection ?: 'desc';
        
        if ($this->timeFrom || $this->timeTo) {
            $this->showTimeFilters = true;
        }
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

    public function updatingDateFilter(): void
    {
        $this->resetPage();
        
        if ($this->dateFilter !== 'custom') {
            $this->clearDateRange();
        }
    }

    public function updatingDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatingDateTo(): void
    {
        $this->resetPage();
    }

    public function updatingTimeFrom(): void
    {
        $this->resetPage();
    }

    public function updatingTimeTo(): void
    {
        $this->resetPage();
    }

    public function clearDateRange(): void
    {
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->timeFrom = '';
        $this->timeTo = '';
        $this->dateFilter = '';
        $this->showTimeFilters = false;
        $this->resetPage();
    }

    public function toggleTimeFilters(): void
    {
        $this->showTimeFilters = !$this->showTimeFilters;
        
        if (!$this->showTimeFilters) {
            $this->timeFrom = '';
            $this->timeTo = '';
        }
    }

    protected function applyDateTimeFilter($query): void
    {
        if (!$this->dateFrom && !$this->dateTo) {
            return;
        }

        if ($this->dateFrom) {
            $fromDateTime = Carbon::parse($this->dateFrom);
            
            if ($this->timeFrom) {
                $fromDateTime->setTimeFromTimeString($this->timeFrom);
            } else {
                $fromDateTime->startOfDay();
            }
            
            $query->where('created_at', '>=', $fromDateTime);
        }

        if ($this->dateTo) {
            $toDateTime = Carbon::parse($this->dateTo);
            
            if ($this->timeTo) {
                $toDateTime->setTimeFromTimeString($this->timeTo);
            } else {
                $toDateTime->endOfDay();
            }
            
            $query->where('created_at', '<=', $toDateTime);
        }
    }

    protected function getModelClass(): string
    {
        return AuditLog::class;
    }

    protected function getForeignKeyForRelation(string $relation): string
    {
        return match($relation) {
            'user' => 'audit_logs.user_id',
            default => "{$relation}_id",
        };
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
            ->when($this->dateFilter && $this->dateFilter !== 'custom', function ($query) {
                match ($this->dateFilter) {
                    'today' => $query->whereDate('created_at', today()),
                    'yesterday' => $query->whereDate('created_at', today()->subDay()),
                    'last_7_days' => $query->where('created_at', '>=', now()->subDays(7)),
                    'last_30_days' => $query->where('created_at', '>=', now()->subDays(30)),
                    'this_month' => $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year),
                    'last_month' => $query->whereMonth('created_at', now()->subMonth()->month)
                        ->whereYear('created_at', now()->subMonth()->year),
                    default => null,
                };
            })
            ->when($this->dateFrom || $this->dateTo, function ($query) {
                $this->applyDateTimeFilter($query);
            });

        $auditLogs = $this->applySorting($auditLogs);

        $auditLogs = $auditLogs->paginate(15);

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

        return view('livewire.audit-logs.table-page', [
            'auditLogs' => $auditLogs,
            'events' => $events,
            'auditableTypes' => $auditableTypes,
        ]);
    }
}