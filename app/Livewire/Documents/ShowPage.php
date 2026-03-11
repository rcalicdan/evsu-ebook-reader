<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use App\Models\DocumentView;
use App\Models\ReadLater;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ShowPage extends Component
{
    use AuthorizesRequests;

    public Document $document;
    public bool $isInReadLater = false;
    public int $readLaterLastPage = 1;
    public array $viewsByCourse = [];

    public function mount(Document $document): void
    {
        $this->authorize('view', $document);

        $this->document = $document->load(['tags', 'category', 'uploader']);

        $this->trackDocumentView();
        $this->loadReadLaterState();
        $this->loadViewsByCourse();
    }

    protected function trackDocumentView(): void
    {
        $user = auth()->user();

        // Skip superadmins and guests entirely
        if (! $user || $user->isSuperAdmin()) {
            return;
        }

        // Skip users that are not admin and have no course assigned
        if (! $user->isAdmin() && $user->course === null) {
            return;
        }

        $alreadyViewed = DocumentView::where('document_id', $this->document->id)
            ->where('user_id', $user->id)
            ->exists();

        if (! $alreadyViewed) {
            $this->document->incrementViewCount();

            DocumentView::create([
                'document_id' => $this->document->id,
                'user_id'     => $user->id,
                'course'      => $user->course?->value,
            ]);
        }
    }

    protected function loadReadLaterState(): void
    {
        if (auth()->check()) {
            $entry = ReadLater::where('user_id', auth()->id())
                ->where('document_id', $this->document->id)
                ->first();

            $this->isInReadLater = (bool) $entry;
            $this->readLaterLastPage = $entry?->last_page ?? 1;
        }
    }

    protected function loadViewsByCourse(): void
    {
        $this->viewsByCourse = $this->document
            ->views()
            ->whereNotNull('course')
            ->selectRaw('course, count(*) as total')
            ->groupBy('course')
            ->pluck('total', 'course')
            ->toArray();
    }

    public function toggleReadLater(): void
    {
        $user = auth()->user();

        $entry = ReadLater::where('user_id', $user->id)
            ->where('document_id', $this->document->id)
            ->first();

        if ($entry) {
            $entry->delete();
            $this->isInReadLater = false;
            $this->readLaterLastPage = 1;
        } else {
            ReadLater::create([
                'user_id'     => $user->id,
                'document_id' => $this->document->id,
                'last_page'   => 1,
            ]);
            $this->isInReadLater = true;
        }

        $this->dispatch('read-later-updated');
    }

    public function saveProgress(int $page): void
    {
        ReadLater::where('user_id', auth()->id())
            ->where('document_id', $this->document->id)
            ->update(['last_page' => $page]);
    }

    public function render()
    {
        return view('livewire.documents.show-page');
    }
}