<?php

namespace App\Livewire\Users;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("components.layouts.app")]
class TablePage extends Component
{
    use WithPagination, AuthorizesRequests;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'role')]
    public string $roleFilter = '';

    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function deleteUser(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);

            $this->authorize('delete', $user);

            $userName = $user->full_name;

            $user->delete();

            $this->dispatch(
                'notify',
                message: "{$userName} has been deleted successfully.",
                type: 'success'
            );
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch(
                'notify',
                message: 'You do not have permission to delete this user.',
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while deleting the user. Please try again.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                        ->orWhere('last_name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $this->search . '%']);
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.users.table-page', [
            'users' => $users,
            'roles' => $this->getRoles(),
        ]);
    }

    private function getRoles(): array
    {
        return array_reduce(
            UserRole::cases(),
            fn($carry, $role) => $carry + [$role->value => $role->label()],
            ['' => 'All Roles']
        );
    }
}