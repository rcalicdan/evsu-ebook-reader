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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="documentViewer()"
        @pdf-progress.window="$wire.saveProgress($event.detail.page)">
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
                            {{ $document->category->name ?? 'Not Set' }}
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
            </x-form.card>

            <!-- Tags Card -->
            <x-form.card>
                <x-slot:title>
                    <h3 class="text-lg font-bold text-gray-800">Tags</h3>
                    <p class="text-sm text-gray-500 font-normal mt-1">Categories and labels for this document.</p>
                </x-slot:title>

                @if ($document->tags->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach ($document->tags as $tag)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-university-red/10 text-university-red rounded-lg text-sm font-medium border border-university-red/20 transition-colors hover:bg-university-red/20">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500 font-medium">No tags assigned</p>
                        <p class="text-xs text-gray-400 mt-1">This document doesn't have any tags yet.</p>
                        @can('update', $document)
                            <a href="{{ route('documents.edit', $document) }}"
                                class="mt-3 text-xs text-university-red hover:text-university-red/80 font-medium">
                                Add tags →
                            </a>
                        @endcan
                    </div>
                @endif
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

                    <!-- Total Views — clickable -->
                    <button
                        wire:click="$set('showViewsModal', true)"
                        class="w-full text-left p-4 bg-blue-50 rounded-xl border border-blue-100 hover:bg-blue-100 transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-lg flex items-center justify-center transition-colors">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-blue-600 font-medium uppercase">Total Views</p>
                                <p class="text-xl font-bold text-blue-900">{{ number_format($document->view_count) }}</p>
                            </div>
                            <svg class="w-4 h-4 text-blue-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mt-2 text-xs text-blue-500">Click to see breakdown by course</p>
                    </button>

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
                            'BSChE' => ['bg' => 'bg-orange-50',  'border' => 'border-orange-200', 'label' => 'text-orange-700', 'count' => 'text-orange-900', 'bar_bg' => 'bg-orange-100', 'bar_fill' => 'bg-orange-500'],
                            'BSCE'  => ['bg' => 'bg-yellow-50',  'border' => 'border-yellow-200', 'label' => 'text-yellow-700', 'count' => 'text-yellow-900', 'bar_bg' => 'bg-yellow-100', 'bar_fill' => 'bg-yellow-500'],
                            'BSEE'  => ['bg' => 'bg-blue-50',    'border' => 'border-blue-200',   'label' => 'text-blue-700',   'count' => 'text-blue-900',   'bar_bg' => 'bg-blue-100',   'bar_fill' => 'bg-blue-500'],
                            'BSECE' => ['bg' => 'bg-indigo-50',  'border' => 'border-indigo-200', 'label' => 'text-indigo-700', 'count' => 'text-indigo-900', 'bar_bg' => 'bg-indigo-100', 'bar_fill' => 'bg-indigo-500'],
                            'BSGE'  => ['bg' => 'bg-green-50',   'border' => 'border-green-200',  'label' => 'text-green-700',  'count' => 'text-green-900',  'bar_bg' => 'bg-green-100',  'bar_fill' => 'bg-green-500'],
                            'BSIE'  => ['bg' => 'bg-pink-50',    'border' => 'border-pink-200',   'label' => 'text-pink-700',   'count' => 'text-pink-900',   'bar_bg' => 'bg-pink-100',   'bar_fill' => 'bg-pink-500'],
                            'BSIT'  => ['bg' => 'bg-violet-50',  'border' => 'border-violet-200', 'label' => 'text-violet-700', 'count' => 'text-violet-900', 'bar_bg' => 'bg-violet-100', 'bar_fill' => 'bg-violet-500'],
                            'BSME'  => ['bg' => 'bg-teal-50',    'border' => 'border-teal-200',   'label' => 'text-teal-700',   'count' => 'text-teal-900',   'bar_bg' => 'bg-teal-100',   'bar_fill' => 'bg-teal-500'],
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

@include('livewire.documents.show-scripts')
@include('livewire.documents.show-css')