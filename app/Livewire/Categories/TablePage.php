<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Traits\WithSorting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("components.layouts.app")]
class TablePage extends Component
{
    use WithPagination, AuthorizesRequests, WithSorting;

    #[Url(as: 'q')]
    public string $search = '';

    public int $perPage = 10;

    protected array $sortableColumns = ['id', 'name'];

    public function mount(): void
    {
        $this->authorize('viewAny', Category::class);

        $this->sortField = $this->sortField ?: 'id';
        $this->sortDirection = $this->sortDirection ?: 'asc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteCategory(int $categoryId): void
    {
        try {
            $category = Category::findOrFail($categoryId);

            $this->authorize('delete', $category);

            $categoryName = $category->name;

            $category->delete();

            $this->dispatch(
                'notify',
                message: "{$categoryName} has been deleted successfully.",
                type: 'success'
            );
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch(
                'notify',
                message: 'You do not have permission to delete this category.',
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while deleting the category. Please try again.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            });

        $categories = $this->applySorting($categories);

        $categories = $categories->paginate($this->perPage);

        return view('livewire.categories.table-page', [
            'categories' => $categories,
        ]);
    }
}
