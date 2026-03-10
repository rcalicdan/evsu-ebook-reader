<?php

namespace App\Livewire\ReadLater;

use App\Models\Category;
use App\Models\ReadLater;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class IndexPage extends Component
{
    use WithPagination;

    #[Url]
    public string $filter = 'all';

    #[Url]
    public string $search = '';

    #[Url]
    public string $categoryId = '';

    public ?int $activeDocumentId = null;

    public string $activeDocumentTitle = '';

    public string $activeDocumentPreviewUrl = '';

    public bool $isInReadLater = false;

    public int $readLaterLastPage = 1;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryId(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function entries()
    {
        return ReadLater::query()
            ->where('user_id', auth()->id())
            ->with('document.category')
            ->when($this->filter === 'unread', fn($q) => $q->where('is_read', false))
            ->when($this->filter === 'read',   fn($q) => $q->where('is_read', true))
            ->when($this->search, fn($q) => $q->whereHas(
                'document',
                fn($dq) =>
                $dq->where('title', 'like', '%' . $this->search . '%')
            ))
            ->when($this->categoryId, fn($q) => $q->whereHas(
                'document',
                fn($dq) =>
                $dq->where('category_id', $this->categoryId)
            ))
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function counts(): array
    {
        $base = ReadLater::query()
            ->where('user_id', auth()->id())
            ->when($this->search, fn($q) => $q->whereHas(
                'document',
                fn($dq) =>
                $dq->where('title', 'like', '%' . $this->search . '%')
            ))
            ->when($this->categoryId, fn($q) => $q->whereHas(
                'document',
                fn($dq) =>
                $dq->where('category_id', $this->categoryId)
            ));

        return [
            'all'    => (clone $base)->count(),
            'unread' => (clone $base)->where('is_read', false)->count(),
            'read'   => (clone $base)->where('is_read', true)->count(),
        ];
    }

    #[Computed]
    public function categories()
    {
        return Category::whereHas(
            'documents.readLaterEntries',
            fn($q) =>
            $q->where('user_id', auth()->id())
        )->orderBy('name')->get();
    }

    public function setActiveDocument(int $entryId): void
    {
        $entry = ReadLater::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->with('document')
            ->firstOrFail();

        $this->activeDocumentId    = $entry->document_id;
        $this->activeDocumentTitle = $entry->document->title;
        $this->activeDocumentPreviewUrl = route('documents.preview', $entry->document);
        $this->readLaterLastPage   = $entry->last_page;
        $this->isInReadLater       = true;
    }

    public function saveProgress(int $page): void
    {
        if (! $this->activeDocumentId) {
            return;
        }

        ReadLater::where('user_id', auth()->id())
            ->where('document_id', $this->activeDocumentId)
            ->update(['last_page' => $page]);
    }

    public function toggleReadLater(): void
    {
        if (! $this->activeDocumentId) {
            return;
        }

        ReadLater::where('user_id', auth()->id())
            ->where('document_id', $this->activeDocumentId)
            ->delete();

        $this->isInReadLater    = false;
        $this->activeDocumentId = null;

        $this->dispatch('read-later-updated');
    }

    public function toggleRead(int $entryId): void
    {
        $entry = ReadLater::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $entry->is_read ? $entry->markAsUnread() : $entry->markAsRead();

        $this->dispatch('read-later-updated');
    }

    public function remove(int $entryId): void
    {
        ReadLater::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->delete();

        $this->dispatch('read-later-updated');
    }

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.read-later.index-page');
    }
}
