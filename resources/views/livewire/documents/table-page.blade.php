<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Document Management</h1>
            <p class="text-sm text-gray-500">Browse, manage, and organize all documents in the system.</p>
        </div>
    </div>

    <!-- Main Table Section -->
    <x-table.index>
        <!-- Search & Filters -->
        <x-table.header>
            <div class="flex flex-col md:flex-row gap-3 w-full">
                <!-- Search -->
                <div class="relative flex-1 min-w-0">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search documents..."
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filters -->
                <div class="flex flex-col md:flex-row gap-2 md:shrink-0">
                    <!-- Category Filter -->
                    <select wire:model.live="categoryFilter"
                        class="w-full md:w-36 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <!-- Visibility Filter -->
                    <select wire:model.live="visibilityFilter"
                        class="w-full md:w-32 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Visibility</option>
                        @foreach ($visibilityOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select wire:model.live="statusFilter"
                        class="w-full md:w-28 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Status</option>
                        @foreach ($statusOptions as $option)
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header>ID</x-table.cell>
                    <x-table.cell header>Document</x-table.cell>
                    <x-table.cell header>Category</x-table.cell>
                    <x-table.cell header class="text-center">Visibility</x-table.cell>
                    <x-table.cell header class="text-center">Status</x-table.cell>
                    <x-table.cell header class="text-center">Date Uploaded</x-table.cell>
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
                                        class="flex-shrink-0 w-10 h-10 bg-university-red/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-gray-900 truncate">{{ $document->title }}</p>
                                        @if ($document->description)
                                            <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">
                                                {{ $document->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    {{ $document->category->name ?? "Not Set" }}
                                </span>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex justify-center">
                                    @if ($document->visibility === \App\Enums\DocumentVisibility::PUBLIC)
                                        <x-ui.badge variant="success">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Public
                                        </x-ui.badge>
                                    @else
                                        <x-ui.badge variant="warning">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Restricted
                                        </x-ui.badge>
                                    @endif
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex justify-center">
                                    <x-ui.badge :variant="$document->status->color()">
                                        {{ $document->status->label() }}
                                    </x-ui.badge>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="text-center">
                                    <p class="text-xs text-gray-500">{{ $document->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $document->created_at->format('g:i A') }}</p>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    <x-ui.view-button :href="route('documents.show', $document)" />

                                    @can('update', $document)
                                        <x-ui.edit-button :href="route('documents.edit', $document)" />
                                    @endcan

                                    @can('delete', $document)
                                        <x-ui.delete-button :id="$document->id" :name="$document->title" resource="Document"
                                            wire="deleteDocument" />
                                    @endcan
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium text-lg">No documents found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or upload a new
                                        document</p>
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
