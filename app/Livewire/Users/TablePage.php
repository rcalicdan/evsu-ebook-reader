<?php

namespace App\Livewire\Users;

use App\Enums\UserRole;
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

    #[Url(as: 'role')]
    public string $roleFilter = '';

    public int $perPage = 10;

    protected array $sortableColumns = ['id', 'first_name', 'email', 'role'];

    public function mount(): void
    {
        $this->authorize('viewAny', User::class);

        $this->sortField = $this->sortField ?: 'id';
        $this->sortDirection = $this->sortDirection ?: 'asc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function approveUser(int $userId): void
    {
        try {
            $user = User::findOrFail($userId);

            $this->authorize('update', $user);

            $user->update([
                'is_approved' => true,
                'is_rejected' => false,
            ]);

            $this->dispatch(
                'notify',
                message: "{$user->full_name} has been approved successfully.",
                type: 'success'
            );
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch(
                'notify',
                message: 'You do not have permission to approve this user.',
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while approving the user. Please try again.',
                type: 'error'
            );
        }
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
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.$this->search.'%']);
                });
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            });

        $users = $this->applySorting($users);

        $users = $users->paginate($this->perPage);

        return view('livewire.users.table-page', [
            'users' => $users,
            'roles' => $this->getRoles(),
        ]);
    }

    private function getRoles(): array
    {
        return array_reduce(
            UserRole::cases(),
            fn ($carry, $role) => $carry + [$role->value => $role->label()],
            ['' => 'All Roles']
        );
    }
}