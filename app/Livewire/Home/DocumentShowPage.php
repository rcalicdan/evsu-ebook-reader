<?php

namespace App\Livewire\Home;

use App\Models\Document;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class DocumentShowPage extends Component
{
    public Document $document;

    public function mount(Document $document): void
    {
        abort_unless(
            $document->isPublic() && ($document->isActive() || $document->isArchived()),
            404,
            'Document not found or not available.'
        );

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
        return view('livewire.home.document-show-page');
    }
}
