<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout("components.layouts.app")]
class TablePage extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = '';
    
    #[Url]
    public $status = '';
    
    #[Url]
    public $perPage = 10;
    
    #[Url]
    public $sortBy = 'created_at';
    
    #[Url]
    public $sortDirection = 'desc';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortByColumn($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        session()->flash('success', 'Category deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);
        
        session()->flash('success', 'Category status updated!');
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== '', function ($query) {
                $query->where('is_active', $this->status);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.categories.table-page', [
            'categories' => $categories
        ]);
    }
}