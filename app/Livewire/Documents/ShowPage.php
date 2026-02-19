<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class ShowPage extends Component
{
    use AuthorizesRequests;

    public Document $document;

    public function mount(Document $document): void
    {
        $this->authorize('view', $document);

        $this->document = $document->load(['tags', 'category', 'uploader']);

        $this->trackDocumentView();
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

    public function render()
    {
        return view('livewire.documents.show-page');
    }
}
