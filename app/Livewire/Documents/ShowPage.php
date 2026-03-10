<?php

namespace App\Livewire\Documents;

use App\Models\Document;
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

    public function mount(Document $document): void
    {
        $this->authorize('view', $document);

        $this->document = $document->load(['tags', 'category', 'uploader']);

        $this->trackDocumentView();
        $this->loadReadLaterState();
    }

    protected function trackDocumentView(): void
    {
        $userId = auth()->id();
        $sessionKey = "document_viewed_{$this->document->id}_user_{$userId}";

        if (! Session::has($sessionKey)) {
            $this->document->incrementViewCount();
            Session::put($sessionKey, now()->timestamp);
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
