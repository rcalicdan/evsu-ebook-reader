<?php

namespace App\Livewire\Documents;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
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

    #[Url]
    public string $statusFilter = '';

    #[Url]
    public string $visibilityFilter = '';

    #[Url]
    public string $categoryFilter = '';

    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'visibilityFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
    ];

    public function mount(): void
    {
        $this->authorize('viewAny', Document::class);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingVisibilityFilter(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function deleteDocument(int $documentId): void
    {
        try {
            $document = Document::findOrFail($documentId);

            $this->authorize('delete', $document);

            $documentTitle = $document->title;

            // Delete the file from storage
            if ($document->file_url && Storage::disk('public')->exists($document->file_url)) {
                Storage::disk('public')->delete($document->file_url);
            }

            $document->delete();

            $this->dispatch(
                'notify',
                message: "{$documentTitle} has been deleted successfully.",
                type: 'success'
            );
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch(
                'notify',
                message: 'You do not have permission to delete this document.',
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while deleting the document. Please try again.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        $documents = Document::query()
            ->with(['uploader', 'category'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->visibilityFilter, function ($query) {
                $query->where('visibility', $this->visibilityFilter);
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category_id', $this->categoryFilter);
            })
            ->latest()
            ->paginate($this->perPage);

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('livewire.documents.table-page', [
            'documents' => $documents,
            'categories' => $categories,
            'statusOptions' => DocumentStatus::cases(),
            'visibilityOptions' => DocumentVisibility::cases(),
        ]);
    }
}