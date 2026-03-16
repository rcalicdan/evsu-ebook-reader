<?php

namespace App\Livewire\Home;

use App\Models\Document;
use App\Models\DocumentComment;
use App\Models\DocumentView;
use App\Models\ReadLater;
use App\Services\RedirectNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.guest')]
class DocumentShowPage extends Component
{
    use WithPagination;

    public Document $document;
    public bool $isInReadLater = false;
    public int $readLaterLastPage = 1;
    public array $viewsByCourse = [];
    public bool $showViewsModal = false;

    // Comment properties
    public string $commentBody = '';
    public string $replyBody = '';
    public ?int $replyingTo = null;

    // Edit properties
    public ?int $editingComment = null;
    public string $editBody = '';

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

    public function postComment(): void
    {
        $this->validate([
            'commentBody' => ['required', 'string', 'min:2', 'max:1000'],
        ], [
            'commentBody.required' => 'Please write a comment before posting.',
            'commentBody.min'      => 'Comment must be at least 2 characters.',
            'commentBody.max'      => 'Comment must not exceed 1000 characters.',
        ]);

        DocumentComment::create([
            'document_id' => $this->document->id,
            'user_id'     => auth()->id(),
            'parent_id'   => null,
            'comment'     => trim($this->commentBody),
        ]);

        $this->commentBody = '';
        $this->resetPage();
    }

    public function postReply(): void
    {
        $this->validate([
            'replyBody'  => ['required', 'string', 'min:2', 'max:1000'],
            'replyingTo' => ['required', 'exists:document_comments,id'],
        ], [
            'replyBody.required' => 'Please write a reply before posting.',
            'replyBody.min'      => 'Reply must be at least 2 characters.',
            'replyBody.max'      => 'Reply must not exceed 1000 characters.',
        ]);

        DocumentComment::create([
            'document_id' => $this->document->id,
            'user_id'     => auth()->id(),
            'parent_id'   => $this->replyingTo,
            'comment'     => trim($this->replyBody),
        ]);

        $this->replyBody  = '';
        $this->replyingTo = null;
    }

    public function editComment(int $commentId): void
    {
        $comment = DocumentComment::findOrFail($commentId);

        if (! Gate::check('update', $comment)) {
            abort(403);
        }

        if ($this->editingComment === $commentId) {
            $this->cancelEdit();
            return;
        }

        $this->editingComment = $commentId;
        $this->editBody       = $comment->comment;
        $this->replyingTo     = null;
        $this->replyBody      = '';
    }
    public function updateComment(): void
    {
        $this->validate([
            'editBody' => ['required', 'string', 'min:2', 'max:1000'],
        ], [
            'editBody.required' => 'Comment cannot be empty.',
            'editBody.min'      => 'Comment must be at least 2 characters.',
            'editBody.max'      => 'Comment must not exceed 1000 characters.',
        ]);

        $comment = DocumentComment::findOrFail($this->editingComment);

        if (! Gate::check('update', $comment)) {
            abort(403);
        }

        $comment->update([
            'comment'   => trim($this->editBody),
            'is_edited' => true,
            'edited_at' => now(),
        ]);

        $this->editingComment = null;
        $this->editBody       = '';
    }
    public function cancelEdit(): void
    {
        $this->editingComment = null;
        $this->editBody       = '';
    }

    public function deleteComment(int $commentId): void
    {
        $comment = DocumentComment::findOrFail($commentId);

        if (! Gate::check('delete', $comment)) {
            abort(403);
        }

        $comment->delete();

        $remaining = DocumentComment::where('document_id', $this->document->id)
            ->whereNull('parent_id')
            ->count();

        if ($remaining > 0 && $this->getPage() > ceil($remaining / 5)) {
            $this->previousPage();
        }
    }

    public function setReplyingTo(int $commentId): void
    {
        $this->replyingTo     = ($this->replyingTo === $commentId) ? null : $commentId;
        $this->replyBody      = '';
        $this->editingComment = null;
        $this->editBody       = '';
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->replyBody  = '';
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
        $comments = DocumentComment::where('document_id', $this->document->id)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->paginate(5);

        $totalComments = DocumentComment::where('document_id', $this->document->id)
            ->whereNull('parent_id')
            ->count();

        return view('livewire.home.document-show-page', [
            'comments'      => $comments,
            'totalComments' => $totalComments,
        ]);
    }
}
