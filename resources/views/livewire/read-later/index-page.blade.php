<div class="min-h-screen bg-gray-50" x-data="documentViewer()" @pdf-progress.window="$wire.saveProgress($event.detail.page)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

        {{-- Header --}}
        <div class="mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Read Later</h1>
            <p class="mt-1 sm:mt-2 text-sm text-gray-600">Documents you've saved to read later</p>
        </div>

        {{-- Search & Category Filter --}}
        <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row gap-3">
            {{-- Search --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search saved documents..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-university-red focus:border-university-red transition-shadow">
            </div>

            {{-- Category Filter --}}
            <div class="w-full sm:w-56">
                <select wire:model.live="categoryId"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-university-red focus:border-university-red transition-shadow">
                    <option value="">All Categories</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="mb-4 sm:mb-6 border-b border-gray-200 overflow-x-auto">
            <nav class="-mb-px flex space-x-4 sm:space-x-8 min-w-max px-1">
                <button wire:click="setFilter('all')"
                    class="{{ $filter === 'all' ? 'border-university-red text-university-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    All ({{ $this->counts['all'] }})
                </button>
                <button wire:click="setFilter('unread')"
                    class="{{ $filter === 'unread' ? 'border-university-red text-university-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Unread ({{ $this->counts['unread'] }})
                </button>
                <button wire:click="setFilter('read')"
                    class="{{ $filter === 'read' ? 'border-university-red text-university-red' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-3 sm:py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                    Read ({{ $this->counts['read'] }})
                </button>
            </nav>
        </div>

        {{-- Documents List --}}
        <div class="space-y-3 sm:space-y-4">
            @forelse ($this->entries as $entry)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow {{ $entry->is_read ? 'opacity-75' : '' }}">
                    <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">

                        {{-- Read status icon - Hidden on mobile, shown on desktop --}}
                        <div class="hidden sm:block flex-shrink-0 mt-1">
                            @if ($entry->is_read)
                                <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0 w-full">
                            {{-- Mobile: Status badge + File type in one row --}}
                            <div class="flex items-start justify-between gap-2 mb-2 sm:hidden">
                                @if ($entry->is_read)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Read
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Unread
                                    </span>
                                @endif

                                @php
                                    $ext = strtoupper(pathinfo($entry->document->file_url, PATHINFO_EXTENSION));
                                    $badgeColor = match ($ext) {
                                        'PDF' => 'bg-blue-100 text-blue-800',
                                        'DOCX' => 'bg-purple-100 text-purple-800',
                                        'ZIP' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeColor }}">
                                    {{ $ext }}
                                </span>
                            </div>

                            {{-- Title and metadata --}}
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 line-clamp-2 sm:line-clamp-1">
                                        {{ $entry->document->title }}
                                    </h3>
                                    
                                    {{-- Metadata - Responsive layout --}}
                                    <div class="mt-1 sm:mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs sm:text-sm text-gray-500">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span class="truncate max-w-[120px] sm:max-w-none">
                                                {{ $entry->document->category?->name ?? 'Uncategorized' }}
                                            </span>
                                        </span>
                                        
                                        <span class="hidden sm:inline">•</span>
                                        
                                        <span class="hidden sm:inline">
                                            Added {{ $entry->created_at->diffForHumans() }}
                                        </span>
                                        
                                        <span class="sm:hidden text-gray-400">
                                            {{ $entry->created_at->diffForHumans() }}
                                        </span>
                                        
                                        @if ($entry->is_read)
                                            <span class="hidden sm:inline">•</span>
                                            <span class="text-green-600 hidden sm:inline">
                                                Read {{ $entry->read_at->diffForHumans() }}
                                            </span>
                                        @elseif ($entry->last_page > 1)
                                            <span>•</span>
                                            <span class="text-blue-600 font-medium">
                                                Page {{ $entry->last_page }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- File type badge - Desktop only --}}
                                @php
                                    $ext = strtoupper(pathinfo($entry->document->file_url, PATHINFO_EXTENSION));
                                    $badgeColor = match ($ext) {
                                        'PDF' => 'bg-blue-100 text-blue-800',
                                        'DOCX' => 'bg-purple-100 text-purple-800',
                                        'ZIP' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="hidden sm:inline-flex shrink-0 items-center px-3 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                    {{ $ext }}
                                </span>
                            </div>

                            {{-- Actions - Mobile: Vertical stack, Desktop: Horizontal --}}
                            <div class="mt-3 sm:mt-4 flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-2 sm:gap-3">
                                {{-- Primary action button - Full width on mobile --}}
                                <button
                                    @click="$wire.setActiveDocument({{ $entry->id }}).then(() => openPreview($wire.activeDocumentPreviewUrl, $wire.readLaterLastPage, true))"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 sm:py-2 text-sm text-white bg-university-red hover:bg-university-red/90 font-medium rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    {{ $entry->last_page > 1 ? 'Resume Reading' : 'View Document' }}
                                </button>

                                {{-- Secondary actions - Horizontal on mobile --}}
                                <div class="flex items-center justify-center sm:justify-start gap-3 text-sm">
                                    <button wire:click="toggleRead({{ $entry->id }})"
                                        class="inline-flex items-center gap-1 font-medium {{ $entry->is_read ? 'text-gray-500 hover:text-gray-700' : 'text-green-600 hover:text-green-800' }} transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="hidden sm:inline">{{ $entry->is_read ? 'Mark as Unread' : 'Mark as Read' }}</span>
                                        <span class="sm:hidden">{{ $entry->is_read ? 'Unread' : 'Read' }}</span>
                                    </button>

                                    <span class="text-gray-300">|</span>

                                    <button wire:click="remove({{ $entry->id }})"
                                        wire:confirm="Remove this document from your read later list?"
                                        class="text-red-500 hover:text-red-700 font-medium transition-colors">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 sm:p-12 text-center">
                    <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                    </svg>
                    <h3 class="mt-3 sm:mt-4 text-base sm:text-lg font-medium text-gray-900">
                        {{ $search || $categoryId ? 'No documents match your filters' : 'No documents saved' }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 px-4">
                        {{ $search || $categoryId ? 'Try adjusting your search or filters' : 'Start saving documents to read them later' }}
                    </p>
                    @if ($search || $categoryId)
                        <button wire:click="$set('search', ''); $set('categoryId', '')"
                            class="mt-4 sm:mt-6 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Clear Filters
                        </button>
                    @else
                        <a href="{{ route('documents.index') }}"
                            class="mt-4 sm:mt-6 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-university-red hover:bg-red-800 transition-colors">
                            Browse Documents
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($this->entries->hasPages())
            <div class="mt-6 sm:mt-8">
                {{ $this->entries->links() }}
            </div>
        @endif
    </div>

    {{-- PDF Preview Modal --}}
    @include('livewire.documents.show-pdf-preview-modal', [
        'modalTitle' => $activeDocumentTitle ?? 'Document Preview',
    ])
</div>

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')