<div class="w-full bg-slate-50 min-h-screen py-12">
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="documentViewer()">
            <!-- Left Column — Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Document Header Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $document->title }}</h1>
                            <p class="text-sm text-slate-500">
                                Published {{ $document->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2 ml-4">
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
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Description</h2>
                            <p class="text-slate-700 leading-relaxed">{{ $document->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- File Preview Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">Document Preview</h2>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div
                            class="flex-shrink-0 w-12 h-12 bg-university-red/10 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
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
                        <button type="button" @click="openPreview('{{ route('documents.preview', $document) }}')"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-university-red text-white text-sm font-medium rounded-lg hover:bg-university-red/90 transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Preview Document
                        </button>
                    </div>
                </div>

                <!-- Tags Card -->
                @if ($document->tags->count() > 0)
                    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">Tags</h2>
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
            </div>

            <!-- Right Column — Sidebar -->
            <div class="space-y-6">

                <!-- Category Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Category</h2>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">
                                {{ $document->category->name ?? 'Uncategorized' }}</p>
                            @if ($document->category?->description)
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ Str::limit($document->category->description, 50) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Statistics Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Statistics</h2>

                    <div class="space-y-3">
                        <!-- View Count -->
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
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
                                    <p class="text-xs text-blue-600 font-medium uppercase">Views</p>
                                    <p class="text-xl font-bold text-blue-900">
                                        {{ number_format($document->view_count) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Published Date -->
                        <div class="p-4 bg-green-50 rounded-lg border border-green-100">
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
                                    <p class="text-xs text-green-600 font-medium uppercase">Published</p>
                                    <p class="text-sm font-bold text-green-900">
                                        {{ $document->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uploader Card -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                    <h2 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Uploaded By</h2>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $document->uploader->full_name }}</p>
                            <p class="text-xs text-slate-500">{{ $document->uploader->role->label() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Login Prompt for Guests -->
                @guest
                    <div class="bg-gradient-to-br from-university-red to-red-700 text-white rounded-xl shadow-lg p-6">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-90" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="text-lg font-bold mb-2">Want to access more?</h3>
                            <p class="text-sm text-white/90 mb-4">Login to save favorites, access restricted documents, and
                                more.</p>
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

            <!-- PDF Preview Modal - Reused from dashboard -->
            @include('livewire.documents.show-pdf-preview-modal')
        </div>
    </div>
</div>

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')
