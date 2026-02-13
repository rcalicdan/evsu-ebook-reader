<?php

namespace App\Livewire\Documents;

use App\Models\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class ShowPage extends Component
{
    use AuthorizesRequests;

    public Document $document;

    public function mount(Document $document): void
    {
        $this->authorize('view', $document);

        $this->document = $document->load(['tags', 'category', 'uploader']);
        $this->document->incrementViewCount();
    }

    public function render()
    {
        return view('livewire.documents.show-page');
    }
}