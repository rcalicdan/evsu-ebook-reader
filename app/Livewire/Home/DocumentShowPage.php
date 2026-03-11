<?php

namespace App\Livewire\Home;

use App\Models\Document;
use App\Models\DocumentView;
use App\Models\ReadLater;
use App\Services\RedirectNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class DocumentShowPage extends Component
{
    public Document $document;
    public bool $isInReadLater = false;
    public int $readLaterLastPage = 1;
    public array $viewsByCourse = [];
    public bool $showViewsModal = false; 

    public function mount(Document $document): void
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

        abort_unless(
            $document->isPublic() && ($document->isActive() || $document->isArchived()),
            404,
            'Document not found or not available.'
        );

        $this->document = $document->load(['tags', 'category', 'uploader']);

        $this->trackDocumentView();
        $this->loadReadLaterState();
        $this->loadViewsByCourse();
    }

    protected function trackDocumentView(): void
    {
        $user = auth()->user();

        if (! $user || $user->isSuperAdmin()) {
            return;
        }

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

            $this->isInReadLater     = (bool) $entry;
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
            $this->isInReadLater     = false;
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
        if (! auth()->check()) {
            return;
        }

        ReadLater::where('user_id', auth()->id())
            ->where('document_id', $this->document->id)
            ->update(['last_page' => $page]);
    }

    public function render()
    {
        return view('livewire.home.document-show-page');
    }
}