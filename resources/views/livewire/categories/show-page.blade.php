<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Category Details</h1>
            <p class="text-sm text-gray-500">View category information and associated documents.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button variant="secondary" size="sm" href="{{ route('categories.index') }}">
                <x-slot:icon>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </x-slot:icon>
                Back to Categories
            </x-ui.button>

            @can('update', $category)
                <x-ui.edit-button :href="route('categories.edit', $category)" size="md">
                    Edit Category
                </x-ui.edit-button>
            @endcan
        </div>
    </div>

    <!-- Category Information Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-bold text-gray-900">Category Information</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Name -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Category Name
                    </label>
                    <p class="text-base font-semibold text-gray-900">{{ $category->name }}</p>
                </div>

                <!-- Category ID -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Category ID
                    </label>
                    <p class="text-base font-mono text-gray-900">{{ $category->id }}</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Description
                    </label>
                    <p class="text-base text-gray-700">
                        {{ $category->description ?: 'No description available.' }}
                    </p>
                </div>

                <!-- Created By -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Created By
                    </label>
                    <div class="flex items-center gap-3">
                        <x-ui.avatar :name="$category->creator?->name ?? 'Unknown'" variant="primary" />
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $category->creator?->name ?? 'Unknown User' }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $category->creator?->email ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Created At -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Created At
                    </label>
                    <p class="text-base text-gray-900">
                        {{ $category->created_at->format('F d, Y') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $category->created_at->diffForHumans() }}
                    </p>
                </div>

                <!-- Document Count -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Total Documents
                    </label>
                    <p class="text-2xl font-bold text-university-red">
                        {{ $category->documents->count() }}
                    </p>
                </div>

                <!-- Last Updated -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Last Updated
                    </label>
                    <p class="text-base text-gray-900">
                        {{ $category->updated_at->format('F d, Y') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $category->updated_at->diffForHumans() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Table -->
    <x-table.index>
        <!-- Search & Actions -->
        <x-table.header>
            <div class="relative w-full md:w-96">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search documents..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            @can('create', \App\Models\Document::class)
                <x-ui.button variant="primary" href="{{ route('uploads.index', ['category' => $category->id]) }}">
                    <x-slot:icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </x-slot:icon>
                    Upload Document
                </x-ui.button>
            @endcan
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header sortable sortField="id">ID</x-table.cell>
                    <x-table.cell header sortable sortField="title">Document Title</x-table.cell>
                    <x-table.cell header>Tags</x-table.cell>
                    <x-table.cell header sortable sortField="view_count">Views</x-table.cell>
                    <x-table.cell header sortable sortField="created_at">Uploaded</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($documents as $document)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $document->id }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="font-bold text-gray-900 truncate">{{ $document->title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            by {{ $document->uploader->name }}
                                        </p>
                                    </div>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex flex-wrap gap-1">
                                    @forelse($document->tags->take(3) as $tag)
                                        <x-ui.badge variant="info">{{ $tag->name }}</x-ui.badge>
                                    @empty
                                        <span class="text-xs text-gray-400">No tags</span>
                                    @endforelse
                                    @if ($document->tags->count() > 3)
                                        <x-ui.badge variant="primary">+{{ $document->tags->count() - 3 }}</x-ui.badge>
                                    @endif
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-600">{{ $document->view_count }}</span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div>
                                    <p class="text-sm text-gray-900">{{ $document->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $document->created_at->diffForHumans() }}</p>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    <x-ui.view-button :href="route('documents.show', $document)" />

                                    @can('update', $document)
                                        <x-ui.edit-button :href="route('documents.edit', $document)" />
                                    @endcan
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No documents found in this category</p>
                                    <p class="text-gray-400 text-sm mt-1">Upload a document to get started</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </table>
        </div>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$documents" />
    </x-table.index>
</div>
