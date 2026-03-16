<div class="w-full bg-slate-50 min-h-screen py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <div class="mb-6">
            <a wire:navigate href="{{ route('home.documents') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-university-red transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Documents
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="documentViewer()"
            @pdf-progress.window="$wire.saveProgress($event.detail.page)">
            <!-- Left Column — Main Content -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                <!-- Document Header Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-xl sm:text-3xl font-bold text-slate-900 mb-2 leading-tight">
                                {{ $document->title }}
                            </h1>
                            <p class="text-sm text-slate-500">
                                Published {{ $document->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex flex-row sm:flex-col gap-2 sm:ml-4 shrink-0">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-{{ $document->status->color() }}-100 text-{{ $document->status->color() }}-800 capitalize">
                                {{ $document->status->label() }}
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-800">
                                Public
                            </span>
                        </div>
                    </div>

                    @if ($document->description)
                    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-slate-200">
                        <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Description</h2>
                        <p class="text-slate-700 leading-relaxed text-sm sm:text-base">{{ $document->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- File Preview Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-4">Document Preview</h2>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                            <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-university-red/10 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-university-red" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-slate-900 truncate">
                                    {{ basename($document->file_url) }}
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    PDF Document • Uploaded {{ $document->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @auth
                            <button wire:click="toggleReadLater"
                                class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border transition-colors
                                        {{ $isInReadLater
                                            ? 'bg-university-red/10 text-university-red border-university-red/30 hover:bg-university-red/20'
                                            : 'bg-white text-gray-600 border-gray-300 hover:border-university-red hover:text-university-red' }}">
                                <svg class="w-4 h-4" fill="{{ $isInReadLater ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                {{ $isInReadLater ? 'Saved' : 'Read Later' }}
                            </button>
                            @endauth

                            <button type="button"
                                @click="openPreview('{{ route('documents.preview', $document) }}', {{ $readLaterLastPage }}, {{ $isInReadLater ? 'true' : 'false' }})"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-university-red text-white text-sm font-medium rounded-lg hover:bg-university-red/90 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tags Card -->
                @if ($document->tags->count() > 0)
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-4">Tags</h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($document->tags as $tag)
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-university-red/10 text-university-red rounded-lg text-sm font-medium border border-university-red/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $tag->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- Comment Section Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">

                    @php
                    $courseColors = [
                    'BSChE' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'badge_bg' => 'bg-orange-100', 'badge_text' => 'text-orange-700'],
                    'BSCE' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'badge_bg' => 'bg-yellow-100', 'badge_text' => 'text-yellow-700'],
                    'BSEE' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'badge_bg' => 'bg-blue-100', 'badge_text' => 'text-blue-700'],
                    'BSECE' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-700', 'badge_bg' => 'bg-indigo-100', 'badge_text' => 'text-indigo-700'],
                    'BSGE' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'badge_bg' => 'bg-green-100', 'badge_text' => 'text-green-700'],
                    'BSIE' => ['bg' => 'bg-pink-100', 'text' => 'text-pink-700', 'badge_bg' => 'bg-pink-100', 'badge_text' => 'text-pink-700'],
                    'BSIT' => ['bg' => 'bg-violet-100', 'text' => 'text-violet-700', 'badge_bg' => 'bg-violet-100', 'badge_text' => 'text-violet-700'],
                    'BSME' => ['bg' => 'bg-teal-100', 'text' => 'text-teal-700', 'badge_bg' => 'bg-teal-100', 'badge_text' => 'text-teal-700'],
                    ];
                    @endphp

                    <h2 class="text-base sm:text-lg font-bold text-slate-900 mb-4">
                        Comments
                        <span class="ml-2 text-sm font-medium text-slate-400">({{ $totalComments }})</span>
                    </h2>

                    {{-- Comment Form --}}
                    @auth
                    <div class="mb-6">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-9 h-9 bg-university-red/10 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <textarea
                                    wire:model="commentBody"
                                    rows="3"
                                    placeholder="Write a comment..."
                                    class="w-full px-4 py-2.5 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-university-red/30 focus:border-university-red transition-colors placeholder:text-slate-400"></textarea>
                                @error('commentBody')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                                <div class="mt-2 flex justify-end">
                                    <button
                                        wire:click="postComment"
                                        type="button"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-university-red text-white text-sm font-medium rounded-lg hover:bg-university-red/90 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        Post Comment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-xl text-center">
                        <p class="text-sm text-slate-500">
                            <a wire:navigate href="{{ route('login') }}" class="text-university-red font-semibold hover:underline">Login</a>
                            to leave a comment.
                        </p>
                    </div>
                    @endauth

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 mb-5"></div>

                    {{-- Comments List --}}
                    <div class="space-y-5">
                        @forelse ($comments as $comment)
                        @php
                        $initials = collect(explode(' ', $comment->user->full_name))
                        ->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                        $course = $comment->user->course?->value;
                        $cc = $courseColors[$course] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'badge_bg' => 'bg-slate-100', 'badge_text' => 'text-slate-600'];
                        $canEditComment = auth()->check() && \Illuminate\Support\Facades\Gate::check('update', $comment);
                        $canDeleteComment = auth()->check() && \Illuminate\Support\Facades\Gate::check('delete', $comment);
                        @endphp

                        <div wire:key="comment-{{ $comment->id }}" class="flex items-start gap-3">

                            {{-- Avatar --}}
                            <div class="flex-shrink-0 w-9 h-9 {{ $cc['bg'] }} rounded-full flex items-center justify-center">
                                <span class="text-xs font-bold {{ $cc['text'] }}">{{ $initials }}</span>
                            </div>

                            <div class="flex-1 min-w-0">

                                {{-- Meta --}}
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="text-sm font-semibold text-slate-800">{{ $comment->user->full_name }}</span>
                                    <span class="text-xs text-slate-400">•</span>
                                    <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    @if ($comment->is_edited)
                                    <span class="text-xs text-slate-400 italic">(edited)</span>
                                    @endif
                                    @if ($course)
                                    <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $cc['badge_bg'] }} {{ $cc['badge_text'] }}">
                                        {{ $course }}
                                    </span>
                                    @elseif ($comment->user->isAdmin() || $comment->user->isSuperAdmin())
                                    <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-university-red/10 text-university-red">
                                        {{ $comment->user->role->label() }}
                                    </span>
                                    @endif
                                </div>

                                {{-- Body or Edit Form --}}
                                @if ($editingComment === $comment->id)
                                <div class="mt-1">
                                    <textarea
                                        wire:model="editBody"
                                        rows="2"
                                        class="w-full px-3 py-2 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-university-red/30 focus:border-university-red transition-colors"></textarea>
                                    @error('editBody')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-2 flex justify-end gap-2">
                                        <button wire:click="cancelEdit" type="button"
                                            class="px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                        <button wire:click="updateComment" type="button"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-university-red hover:bg-university-red/90 rounded-lg transition-colors">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                                @else
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $comment->comment }}</p>
                                @endif

                                {{-- Actions --}}
                                @if ($editingComment !== $comment->id)
                                <div class="mt-2 flex items-center gap-3">
                                    @auth
                                    <button wire:click="setReplyingTo({{ $comment->id }})" type="button"
                                        class="text-xs font-medium transition-colors {{ $replyingTo === $comment->id ? 'text-university-red' : 'text-slate-400 hover:text-university-red' }}">
                                        {{ $replyingTo === $comment->id ? 'Cancel' : 'Reply' }}
                                    </button>

                                    @if ($canEditComment)
                                    <button wire:click="editComment({{ $comment->id }})" type="button"
                                        class="text-xs text-slate-400 hover:text-university-red transition-colors font-medium">
                                        Edit
                                    </button>
                                    @endif

                                    @if ($canDeleteComment)
                                    <button
                                        wire:click="deleteComment({{ $comment->id }})"
                                        wire:confirm="Are you sure you want to delete this comment?"
                                        type="button"
                                        class="text-xs text-slate-400 hover:text-red-500 transition-colors font-medium">
                                        Delete
                                    </button>
                                    @endif
                                    @endauth
                                </div>
                                @endif

                                {{-- Inline Reply Form --}}
                                @auth
                                @if ($replyingTo === $comment->id)
                                <div class="mt-3">
                                    <textarea
                                        wire:model="replyBody"
                                        rows="2"
                                        placeholder="Write a reply..."
                                        class="w-full px-3 py-2 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-university-red/30 focus:border-university-red transition-colors placeholder:text-slate-400"></textarea>
                                    @error('replyBody')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-2 flex justify-end gap-2">
                                        <button wire:click="cancelReply" type="button"
                                            class="px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                        <button wire:click="postReply" type="button"
                                            class="px-3 py-1.5 text-xs font-medium text-white bg-university-red hover:bg-university-red/90 rounded-lg transition-colors">
                                            Post Reply
                                        </button>
                                    </div>
                                </div>
                                @endif
                                @endauth

                                {{-- Nested Replies --}}
                                @if ($comment->replies->count() > 0)
                                <div class="mt-4 space-y-4">
                                    @foreach ($comment->replies as $reply)
                                    @php
                                    $replyInitials = collect(explode(' ', $reply->user->full_name))
                                    ->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                                    $replyCourse = $reply->user->course?->value;
                                    $rcc = $courseColors[$replyCourse] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'badge_bg' => 'bg-slate-100', 'badge_text' => 'text-slate-600'];
                                    $canEditReply = auth()->check() && \Illuminate\Support\Facades\Gate::check('update', $reply);
                                    $canDeleteReply = auth()->check() && \Illuminate\Support\Facades\Gate::check('delete', $reply);
                                    @endphp
                                    <div wire:key="reply-{{ $reply->id }}" class="ml-4 pl-4 border-l-2 border-slate-100 flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 {{ $rcc['bg'] }} rounded-full flex items-center justify-center">
                                            <span class="text-xs font-bold {{ $rcc['text'] }}">{{ $replyInitials }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                <span class="text-sm font-semibold text-slate-800">{{ $reply->user->full_name }}</span>
                                                <span class="text-xs text-slate-400">•</span>
                                                <span class="text-xs text-slate-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                @if ($reply->is_edited)
                                                <span class="text-xs text-slate-400 italic">(edited)</span>
                                                @endif
                                                @if ($replyCourse)
                                                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $rcc['badge_bg'] }} {{ $rcc['badge_text'] }}">
                                                    {{ $replyCourse }}
                                                </span>
                                                @elseif ($reply->user->isAdmin() || $reply->user->isSuperAdmin())
                                                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-university-red/10 text-university-red">
                                                    {{ $reply->user->role->label() }}
                                                </span>
                                                @endif
                                            </div>

                                            {{-- Reply Body or Edit Form --}}
                                            @if ($editingComment === $reply->id)
                                            <div class="mt-1">
                                                <textarea
                                                    wire:model="editBody"
                                                    rows="2"
                                                    class="w-full px-3 py-2 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl resize-none focus:outline-none focus:ring-2 focus:ring-university-red/30 focus:border-university-red transition-colors"></textarea>
                                                @error('editBody')
                                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                                @enderror
                                                <div class="mt-2 flex justify-end gap-2">
                                                    <button wire:click="cancelEdit" type="button"
                                                        class="px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
                                                        Cancel
                                                    </button>
                                                    <button wire:click="updateComment" type="button"
                                                        class="px-3 py-1.5 text-xs font-medium text-white bg-university-red hover:bg-university-red/90 rounded-lg transition-colors">
                                                        Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                            @else
                                            <p class="text-sm text-slate-600 leading-relaxed">{{ $reply->comment }}</p>
                                            @endif

                                            {{-- Reply Actions --}}
                                            @if ($editingComment !== $reply->id)
                                            @auth
                                            <div class="mt-1.5 flex items-center gap-3">
                                                @if ($canEditReply)
                                                <button wire:click="editComment({{ $reply->id }})" type="button"
                                                    class="text-xs text-slate-400 hover:text-university-red transition-colors font-medium">
                                                    Edit
                                                </button>
                                                @endif
                                                @if ($canDeleteReply)
                                                <button
                                                    wire:click="deleteComment({{ $reply->id }})"
                                                    wire:confirm="Are you sure you want to delete this reply?"
                                                    type="button"
                                                    class="text-xs text-slate-400 hover:text-red-500 transition-colors font-medium">
                                                    Delete
                                                </button>
                                                @endif
                                            </div>
                                            @endauth
                                            @endif

                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-slate-500">No comments yet</p>
                            <p class="text-xs text-slate-400 mt-1">Be the first to leave a comment on this document.</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($comments->hasPages())
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between gap-4">

                        {{-- Info --}}
                        <p class="text-xs text-slate-500">
                            Showing {{ $comments->firstItem() }}–{{ $comments->lastItem() }} of {{ $comments->total() }} comments
                        </p>

                        {{-- Controls --}}
                        <div class="flex items-center gap-1">

                            {{-- Previous --}}
                            @if ($comments->onFirstPage())
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                            @else
                            <button wire:click="previousPage" type="button"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 bg-white border border-slate-200 hover:border-university-red hover:text-university-red transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            @endif

                            {{-- Page Numbers --}}
                            @foreach ($comments->getUrlRange(1, $comments->lastPage()) as $page => $url)
                            @if ($page == $comments->currentPage())
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-bold text-white bg-university-red border border-university-red">
                                {{ $page }}
                            </span>
                            @elseif (abs($page - $comments->currentPage()) <= 2)
                                <button wire:click="gotoPage({{ $page }})" type="button"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-medium text-slate-600 bg-white border border-slate-200 hover:border-university-red hover:text-university-red transition-colors">
                                {{ $page }}
                                </button>
                                @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($comments->hasMorePages())
                                <button wire:click="nextPage" type="button"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 bg-white border border-slate-200 hover:border-university-red hover:text-university-red transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                @else
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-300 bg-slate-50 border border-slate-100 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                                @endif

                        </div>
                    </div>
                    @endif

                </div>
                {{-- End Comment Section Card --}}
            </div>

            <!-- Right Column — Sidebar -->
            <div class="space-y-4 sm:space-y-6">

                <!-- Category Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Category</h2>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">
                                {{ $document->category->name ?? 'Uncategorized' }}
                            </p>
                            @if ($document->category?->description)
                            <p class="text-xs text-slate-500 mt-0.5 truncate">
                                {{ Str::limit($document->category->description, 50) }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Statistics</h2>

                    <div class="space-y-3">

                        {{-- Total Views — clickable button --}}
                        <button
                            wire:click="$set('showViewsModal', true)"
                            class="w-full text-left p-3 sm:p-4 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors group cursor-pointer">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-blue-600 font-medium uppercase">Total Views</p>
                                    <p class="text-lg sm:text-xl font-bold text-blue-900">
                                        {{ number_format($document->view_count) }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-blue-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="mt-2 text-xs text-blue-500">Click to see breakdown by course</p>
                        </button>

                        <!-- Published Date -->
                        <div class="p-3 sm:p-4 bg-green-50 rounded-lg border border-green-100">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-9 h-9 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-green-600 font-medium uppercase">Published</p>
                                    <p class="text-sm font-bold text-green-900">
                                        {{ $document->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uploader Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 sm:p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Uploaded By</h2>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 truncate">
                                {{ $document->uploader->full_name }}
                            </p>
                            <p class="text-xs text-slate-500">{{ $document->uploader->role->label() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Login Prompt for Guests -->
                @guest
                <div class="bg-gradient-to-br from-university-red to-red-700 text-white rounded-xl shadow-lg p-5 sm:p-6">
                    <div class="text-center">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 opacity-90" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h3 class="text-base sm:text-lg font-bold mb-2">Want to access more?</h3>
                        <p class="text-sm text-white/90 mb-4">Login to save favorites, access restricted documents,
                            and more.</p>
                        <a wire:navigate href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white text-university-red rounded-lg font-semibold text-sm hover:bg-gray-50 transition-colors">
                            Login Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
                @endguest
            </div>

            <!-- PDF Preview Modal -->
            @include('livewire.documents.show-pdf-preview-modal')
        </div>

        {{-- Views Breakdown Modal --}}
        @if ($showViewsModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="$wire.set('showViewsModal', false)">

            {{-- Backdrop --}}
            <div
                class="absolute inset-0 bg-black/50 backdrop-blur-sm"
                wire:click="$set('showViewsModal', false)">
            </div>

            {{-- Modal Panel --}}
            <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl">

                {{-- Header --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Views by Course</h3>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ number_format($document->view_count) }} total {{ Str::plural('view', $document->view_count) }}
                        </p>
                    </div>
                    <button
                        wire:click="$set('showViewsModal', false)"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="px-6 py-4 space-y-3 max-h-[60vh] overflow-y-auto">
                    @php
                    $modalCourseColors = [
                    'BSChE' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200', 'label' => 'text-orange-700', 'count' => 'text-orange-900', 'bar_bg' => 'bg-orange-100', 'bar_fill' => 'bg-orange-500'],
                    'BSCE' => ['bg' => 'bg-yellow-50', 'border' => 'border-yellow-200', 'label' => 'text-yellow-700', 'count' => 'text-yellow-900', 'bar_bg' => 'bg-yellow-100', 'bar_fill' => 'bg-yellow-500'],
                    'BSEE' => ['bg' => 'bg-blue-50', 'border' => 'border-blue-200', 'label' => 'text-blue-700', 'count' => 'text-blue-900', 'bar_bg' => 'bg-blue-100', 'bar_fill' => 'bg-blue-500'],
                    'BSECE' => ['bg' => 'bg-indigo-50', 'border' => 'border-indigo-200', 'label' => 'text-indigo-700', 'count' => 'text-indigo-900', 'bar_bg' => 'bg-indigo-100', 'bar_fill' => 'bg-indigo-500'],
                    'BSGE' => ['bg' => 'bg-green-50', 'border' => 'border-green-200', 'label' => 'text-green-700', 'count' => 'text-green-900', 'bar_bg' => 'bg-green-100', 'bar_fill' => 'bg-green-500'],
                    'BSIE' => ['bg' => 'bg-pink-50', 'border' => 'border-pink-200', 'label' => 'text-pink-700', 'count' => 'text-pink-900', 'bar_bg' => 'bg-pink-100', 'bar_fill' => 'bg-pink-500'],
                    'BSIT' => ['bg' => 'bg-violet-50', 'border' => 'border-violet-200', 'label' => 'text-violet-700', 'count' => 'text-violet-900', 'bar_bg' => 'bg-violet-100', 'bar_fill' => 'bg-violet-500'],
                    'BSME' => ['bg' => 'bg-teal-50', 'border' => 'border-teal-200', 'label' => 'text-teal-700', 'count' => 'text-teal-900', 'bar_bg' => 'bg-teal-100', 'bar_fill' => 'bg-teal-500'],
                    ];
                    @endphp

                    @forelse ($viewsByCourse as $course => $count)
                    @php
                    $mc = $modalCourseColors[$course] ?? [
                    'bg' => 'bg-gray-50', 'border' => 'border-gray-200',
                    'label' => 'text-gray-700', 'count' => 'text-gray-900',
                    'bar_bg' => 'bg-gray-100', 'bar_fill' => 'bg-gray-500',
                    ];
                    $percent = $document->view_count > 0
                    ? round(($count / $document->view_count) * 100)
                    : 0;
                    @endphp
                    <div class="p-4 {{ $mc['bg'] }} rounded-xl border {{ $mc['border'] }}">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-bold {{ $mc['label'] }}">
                                {{ \App\Enums\Course::from($course)->value }}
                            </span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold {{ $mc['count'] }}">
                                    {{ number_format($count) }} {{ Str::plural('view', $count) }}
                                </span>
                                <span class="text-xs {{ $mc['label'] }} opacity-60 font-medium">
                                    {{ $percent }}%
                                </span>
                            </div>
                        </div>
                        <div class="w-full {{ $mc['bar_bg'] }} rounded-full h-2">
                            <div
                                class="{{ $mc['bar_fill'] }} h-2 rounded-full transition-all duration-500"
                                style="width: {{ $percent }}%">
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">No course data yet</p>
                        <p class="text-xs text-gray-400 mt-1">Views will appear here once students access this document.</p>
                    </div>
                    @endforelse
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                    <button
                        wire:click="$set('showViewsModal', false)"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')