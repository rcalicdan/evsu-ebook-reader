<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Document Details</h1>
            <p class="text-sm text-gray-500">View document information and details.</p>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $document)
                <x-ui.button variant="success" size="sm" href="{{ route('documents.edit', $document) }}">
                    <x-slot:icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </x-slot:icon>
                    Edit
                </x-ui.button>
            @endcan

            <x-ui.button variant="secondary" size="sm" href="{{ route('documents.index') }}">
                <x-slot:icon>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </x-slot:icon>
                Back to Documents
            </x-ui.button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="documentViewer()">
        <!-- Left Column — Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Document Info Card -->
            <x-form.card>
                <x-slot:title>
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Document Information</h3>
                            <p class="text-sm text-gray-500 font-normal mt-1">Details and metadata about this document.
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-ui.badge :variant="$document->status->color()">
                                {{ $document->status->label() }}
                            </x-ui.badge>
                            @if ($document->visibility === \App\Enums\DocumentVisibility::PUBLIC)
                                <x-ui.badge variant="success">Public</x-ui.badge>
                            @else
                                <x-ui.badge variant="warning">Restricted</x-ui.badge>
                            @endif
                        </div>
                    </div>
                </x-slot:title>

                <!-- Title -->
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Title</p>
                        <p class="text-gray-900 font-semibold text-lg">{{ $document->title }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Description</p>
                        @if ($document->description)
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $document->description }}</p>
                        @else
                            <p class="text-gray-400 text-sm italic">No description provided.</p>
                        @endif
                    </div>

                    <!-- Category -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Category</p>
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ $document->category->name }}
                        </span>
                    </div>

                    <!-- Slug -->
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Slug</p>
                        <code class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-lg font-mono">
                            {{ $document->slug }}
                        </code>
                    </div>
                </div>
            </x-form.card>

            <!-- File Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Document File</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">The file associated with this document.</p>
                </x-slot:title>

                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div
                        class="flex-shrink-0 w-12 h-12 bg-university-red/10 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-university-red" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ basename($document->file_url) }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Uploaded on {{ $document->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    <!-- Preview Button -->
                    <button type="button" @click="openPreview('{{ route('documents.preview', $document) }}')"
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
            </x-form.card>
        </div>

        <!-- Right Column — Sidebar -->
        <div class="space-y-6">
            <!-- Statistics Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Statistics</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">Engagement and usage metrics.</p>
                </x-slot:title>

                <div class="space-y-4">
                    <!-- View Count -->
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 font-medium uppercase">Total Views</p>
                                <p class="text-xl font-bold text-blue-900">{{ number_format($document->view_count) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Date -->
                    <div class="p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-green-600 font-medium uppercase">Uploaded Date</p>
                                <p class="text-sm font-bold text-green-900">
                                    {{ $document->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-green-700">{{ $document->created_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-purple-600 font-medium uppercase">Last Updated</p>
                                <p class="text-sm font-bold text-purple-900">
                                    {{ $document->updated_at->format('M d, Y') }}</p>
                                <p class="text-xs text-purple-700">{{ $document->updated_at->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-form.card>

            <!-- Uploader Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Uploaded By</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">The user who uploaded this document.</p>
                </x-slot:title>

                <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ $document->uploader->full_name }}</p>
                        <p class="text-xs text-gray-500">{{ $document->uploader->email }}</p>
                    </div>
                </div>
            </x-form.card>
        </div>

        <!-- PDF Preview Modal -->
        <div x-show="showPreview" x-cloak @keydown.escape.window="closePreview()"
            class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">

            <!-- Dark Glass Backdrop -->
            <div x-show="showPreview" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="closePreview()">
            </div>

            <!-- Modal Panel -->
            <div class="flex h-full w-full items-center justify-center md:p-4">
                <div x-show="showPreview" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                    class="relative w-full h-full md:h-[90vh] md:max-w-6xl flex flex-col bg-white md:rounded-lg shadow-2xl overflow-hidden"
                    @click.stop>

                    <!-- 1. Toolbar Container -->
                    <div
                        class="flex-none z-20 border-b border-gray-200 bg-gray-50 min-h-[52px] flex flex-col justify-center">

                        <!-- A. STANDARD TOOLBAR (Visible by default) -->
                        <div x-show="!showMobileSearch" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="flex flex-wrap items-center justify-between px-3 py-2 md:px-4 md:py-3 gap-2 w-full">

                            <!-- Left: Close & Title -->
                            <div class="flex items-center gap-2 mr-auto min-w-0">
                                <button @click="closePreview()"
                                    class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-200 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <h3
                                    class="text-sm md:text-base font-semibold text-gray-900 truncate max-w-[150px] md:max-w-xs">
                                    {{ $document->title }}</h3>
                            </div>

                            <!-- Right: Controls -->
                            <div class="flex items-center gap-2">

                                <!-- 1. Page Jumper -->
                                <div class="flex items-center bg-white rounded-lg border shadow-sm p-0.5">
                                    <button @click="prevPage()"
                                        class="p-1.5 hover:bg-gray-100 rounded text-gray-600 disabled:opacity-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <span
                                        class="text-xs font-medium text-gray-700 px-2 min-w-[3rem] text-center select-none">
                                        <span x-text="page"></span>/<span x-text="numPages"></span>
                                    </span>
                                    <button @click="nextPage()"
                                        class="p-1.5 hover:bg-gray-100 rounded text-gray-600 disabled:opacity-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- 2. Mobile Search Trigger -->
                                <button
                                    @click="showMobileSearch = true; $nextTick(() => $refs.mobileSearchInput.focus())"
                                    class="md:hidden p-2 bg-white border rounded-lg shadow-sm text-gray-600 hover:text-university-red active:bg-gray-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>

                                <!-- 3. Desktop Search Bar -->
                                <div class="hidden md:flex relative items-center group">
                                    <div
                                        class="flex items-center bg-white border rounded-lg shadow-sm overflow-hidden focus-within:ring-1 focus-within:ring-university-red focus-within:border-university-red">
                                        <div class="pl-2 text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" x-model="searchQuery" @keydown.enter="performSearch()"
                                            placeholder="Find..."
                                            class="w-32 lg:w-48 border-none text-sm focus:ring-0 placeholder-gray-400 py-1.5 pl-2">
                                        <div class="flex border-l bg-gray-50" x-show="searchQuery.length > 0">
                                            <button @click="findPrev()"
                                                class="px-2 py-1.5 hover:bg-gray-200 text-gray-600"><svg
                                                    class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 15l7-7 7 7" />
                                                </svg></button>
                                            <button @click="findNext()"
                                                class="px-2 py-1.5 hover:bg-gray-200 text-gray-600"><svg
                                                    class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- 4. Desktop Zoom -->
                                <div class="hidden md:flex items-center bg-white rounded-lg border shadow-sm p-1">
                                    <button @click="zoomOut()"
                                        class="p-1.5 hover:bg-gray-100 rounded text-gray-600"><svg class="w-4 h-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 12H4" />
                                        </svg></button>
                                    <button @click="zoomIn()"
                                        class="p-1.5 hover:bg-gray-100 rounded text-gray-600"><svg class="w-4 h-4"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4" />
                                        </svg></button>
                                </div>
                            </div>
                        </div>

                        <!-- B. MOBILE SEARCH OVERLAY (Visible only when triggered) -->
                        <div x-show="showMobileSearch" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="w-full bg-white flex items-center px-3 py-2 gap-2 border-b border-gray-200">

                            <!-- Back Button -->
                            <button @click="showMobileSearch = false; searchQuery = ''"
                                class="p-2 text-gray-500 hover:text-gray-700 bg-gray-50 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </button>

                            <!-- Search Input -->
                            <div class="flex-1 relative group">
                                <input type="text" x-ref="mobileSearchInput" x-model="searchQuery"
                                    @keydown.enter="performSearch()" placeholder="Find in document..."
                                    class="w-full bg-gray-100 border-none rounded-lg py-2 pl-3 pr-12 text-sm focus:ring-1 focus:ring-university-red focus:bg-white transition-colors">

                                <span x-show="matchesCount.total > 0"
                                    class="absolute right-3 top-2.5 text-xs text-gray-500 font-medium">
                                    <span x-text="matchesCount.current"></span>/<span
                                        x-text="matchesCount.total"></span>
                                </span>
                            </div>

                            <!-- Next/Prev Buttons -->
                            <div class="flex items-center bg-gray-100 rounded-lg p-0.5 border border-gray-200">
                                <button @click="findPrev()"
                                    class="p-2 text-gray-600 hover:bg-gray-200 rounded active:bg-gray-300">
                                    <!-- CORRECTED SVG: Chevron Up -->
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 15l7-7 7 7" />
                                    </svg>
                                </button>
                                <div class="w-px h-4 bg-gray-300 mx-0.5"></div>
                                <button @click="findNext()"
                                    class="p-2 text-gray-600 hover:bg-gray-200 rounded active:bg-gray-300">
                                    <!-- CORRECTED SVG: Chevron Down -->
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 2. PDF Area Wrapper -->
                    <div class="flex-1 relative w-full bg-gray-100 overflow-hidden">

                        <!-- 3. The PDF.js Container -->
                        <div id="viewerContainer" class="absolute inset-0 overflow-auto">
                            <div id="viewer" class="pdfViewer"></div>
                        </div>

                        <!-- Loading Overlay -->
                        <div x-show="loading"
                            class="absolute inset-0 flex items-center justify-center bg-white/90 z-10">
                            <div class="flex flex-col items-center">
                                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-university-red mb-2">
                                </div>
                                <span class="text-sm text-gray-500 font-medium">Loading Document...</span>
                            </div>
                        </div>

                        <!-- Error Overlay -->
                        <div x-show="error" class="absolute inset-0 flex items-center justify-center bg-white z-20">
                            <div class="text-center p-4">
                                <p class="font-semibold text-red-600" x-text="errorMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')
