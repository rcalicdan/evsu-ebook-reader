<div class="w-full bg-slate-50">
    <!-- Page Header -->
    <header class="bg-gradient-to-b from-white to-slate-50 border-b border-slate-200 py-16 text-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-5xl font-extrabold text-slate-900 tracking-tight">Document Repository</h1>
            <p class="mt-4 text-xl text-slate-600 max-w-2xl mx-auto">
                Explore the digital collection of the School of Engineering.
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filter Section -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 md:p-6 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">

                <!-- Search Input with Debounce -->
                <div class="md:col-span-2 lg:col-span-2">
                    <label for="search"
                        class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">
                        Search Documents
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" 
                               wire:model.live.debounce.500ms="search"
                               id="search"
                               class="block w-full rounded-lg border-slate-300 pl-10 py-2.5 shadow-sm focus:border-university-red focus:ring-4 focus:ring-university-red/10 transition-all sm:text-sm"
                               placeholder="Search by title, author, or keywords...">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-span-1">
                    <label for="category"
                        class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">
                        Category
                    </label>
                    <select wire:model.live="category"
                            id="category"
                            class="block w-full rounded-lg border-slate-300 shadow-sm py-2.5 pl-3 pr-10 text-base focus:border-university-red focus:ring-4 focus:ring-university-red/10 transition-all sm:text-sm">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-span-1">
                    <label for="status"
                        class="block text-[11px] font-bold text-slate-500 uppercase tracking-[0.1em] mb-2">
                        Status
                    </label>
                    <select wire:model.live="status"
                            id="status"
                            class="block w-full rounded-lg border-slate-300 shadow-sm py-2.5 pl-3 pr-10 text-base focus:border-university-red focus:ring-4 focus:ring-university-red/10 transition-all sm:text-sm">
                        <option value="">All Statuses</option>
                        @foreach (App\Enums\DocumentStatus::cases() as $statusOption)
                            <option value="{{ $statusOption->value }}">{{ $statusOption->label() }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <!-- Results Count & Sorting -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-sm text-slate-600">
                Showing <span class="font-semibold text-slate-900">{{ $documents->total() }}</span> results
            </p>
            <div>
                <label for="sort" class="sr-only">Sort by</label>
                <select wire:model.live="sort"
                        id="sort"
                        class="block w-full rounded-lg border-slate-300 shadow-sm py-1.5 pl-3 pr-10 text-sm focus:border-university-red focus:outline-none focus:ring-2 focus:ring-university-red/50">
                    <option value="latest">Date Published</option>
                    <option value="popular">Most Popular</option>
                    <option value="alphabetical">Alphabetical</option>
                </select>
            </div>
        </div>

        <!-- Document Grid -->
        @if($documents->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($documents as $document)
                    <x-guest.document-card :document="$document" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $documents->links('components.guest.pagination') }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">No documents found</h3>
                <p class="mt-1 text-sm text-slate-500">Try adjusting your search or filters.</p>
            </div>
        @endif

    </div>
</div>