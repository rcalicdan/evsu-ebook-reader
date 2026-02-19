<?php

namespace App\Livewire\Home;

use App\Enums\DocumentVisibility;
use App\Models\Category;
use App\Models\Document;
use App\Services\RedirectNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.guest')]
class TablePage extends Component
{
    use WithPagination;

    #[Url(as: 'q', keep: true)]
    public string $search = '';

    #[Url(keep: true)]
    public string $category = '';

    #[Url(keep: true)]
    public string $status = '';

    #[Url(keep: true)]
    public string $sort = 'latest';

    public function mount(): void
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->is_suspended) {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                RedirectNotification::error('Your account has been suspended. Please contact an administrator.');
                $this->redirect(route('login'), navigate: true);
                return;
            }

            if (!$user->is_approved) {
                $this->redirect(route('pending-approval'), navigate: true);
                return;
            }
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingCategory(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function getDocumentsProperty()
    {
        return Document::query()
            ->with(['category', 'uploader'])
            ->where('visibility', DocumentVisibility::PUBLIC)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhereHas('uploader', function ($q) {
                            $q->where('first_name', 'like', "%{$this->search}%")
                                ->orWhere('last_name', 'like', "%{$this->search}%")
                                ->orWhereRaw("CONCAT(first_name, ' ', last_name) ILIKE ?", ["%{$this->search}%"]);
                        });
                });
            })
            ->when($this->category, fn($query) => $query->where('category_id', $this->category))
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->sort === 'latest', fn($query) => $query->latest())
            ->when($this->sort === 'alphabetical', fn($query) => $query->orderBy('title'))
            ->when($this->sort === 'popular', fn($query) => $query->orderByDesc('view_count'))
            ->paginate(25);
    }

    public function getCategoriesProperty()
    {
        return Category::orderBy('name')->get();
    }

    public function render()
    {
        return view('livewire.home.table-page', [
            'documents'  => $this->documents,
            'categories' => $this->categories,
        ]);
    }
}
