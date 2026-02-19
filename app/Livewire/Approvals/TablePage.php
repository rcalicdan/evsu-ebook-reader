<?php

namespace App\Livewire\Approvals;

use App\Enums\Course;
use App\Models\User;
use App\Traits\WithSorting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class TablePage extends Component
{
    use AuthorizesRequests, WithPagination, WithSorting;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'course')]
    public string $courseFilter = '';

    public int $perPage = 10;

    protected array $sortableColumns = ['id', 'first_name', 'email', 'course', 'created_at'];

    public function mount(): void
    {
        $this->authorize('view-approvals');

        $this->sortField     = $this->sortField ?: 'created_at';
        $this->sortDirection = $this->sortDirection ?: 'asc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCourseFilter(): void
    {
        $this->resetPage();
    }

    public function approve(int $userId): void
    {
        $user = User::findOrFail($userId);

        $this->authorize('approve-account', $user);

        try {
            $user->update(['is_approved' => true]);

            $this->dispatch(
                'notify',
                message: "{$user->full_name} has been approved successfully.",
                type: 'success'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while approving the user.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        $authUser = auth()->user();

        $query = User::query()
            ->with('studentProfile')
            ->where('is_approved', false)
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $this->search . '%']);
                });
            })
            ->when($this->courseFilter, fn ($q) => $q->where('course', $this->courseFilter))
            ->when($authUser->isAdmin(), fn ($q) => $q->where('course', $authUser->course));

        $query = $this->applySorting($query);

        $courses = $authUser->isSuperAdmin() ? Course::cases() : [];

        return view('livewire.approvals.table-page', [
            'users'   => $query->paginate($this->perPage),
            'courses' => $courses,
        ]);
    }
}