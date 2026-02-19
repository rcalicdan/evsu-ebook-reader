<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Models\Document;
use App\Traits\WithSorting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class ShowPage extends Component
{
    use AuthorizesRequests, WithPagination, WithSorting;

    public Category $category;

    public string $search = '';

    public int $perPage = 10;

    protected array $sortableColumns = ['id', 'title', 'created_at', 'view_count'];

    public function mount(Category $category): void
    {
        $this->authorize('view', $category);

        $this->sortField = $this->sortField ?: 'created_at';
        $this->sortDirection = $this->sortDirection ?: 'desc';
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $documents = Document::query()
            ->where('category_id', $this->category->id)
            ->with(['uploader', 'tags'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            });

        $documents = $this->applySorting($documents);
        $documents = $documents->paginate($this->perPage);

        return view('livewire.categories.show-page', [
            'documents' => $documents,
        ]);
    }
}
