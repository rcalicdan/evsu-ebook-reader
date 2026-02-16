<x-layouts.guest title="Browse Documents - EVSU Reader">
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
            <!-- Filter Section (Static Modern Version) -->
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 mb-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Search Input (Spans 2 columns on large screens) -->
                    <div class="lg:col-span-2">
                        <label for="search"
                            class="block text-sm font-semibold text-slate-700 uppercase tracking-wider">Search
                            Documents</label>
                        <div class="relative mt-2">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search"
                                class="block w-full rounded-lg border-slate-300 pl-10 py-2.5 shadow-sm focus:border-university-red focus:ring-2 focus:ring-university-red/20 transition-all sm:text-sm"
                                placeholder="Search by title, author, or keywords...">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category"
                            class="block text-sm font-semibold text-slate-700 uppercase tracking-wider">Category</label>
                        <div class="mt-2">
                            <select id="category" name="category"
                                class="block w-full rounded-lg border-slate-300 shadow-sm py-2.5 pl-3 pr-10 text-base focus:border-university-red focus:ring-2 focus:ring-university-red/20 transition-all sm:text-sm">
                                <option>All Categories</option>
                                <option>Research Papers</option>
                                <option>Thesis Archives</option>
                                <option>Capstone Projects</option>
                                <option>E-Books</option>
                            </select>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status"
                            class="block text-sm font-semibold text-slate-700 uppercase tracking-wider">Status</label>
                        <div class="mt-2">
                            <select id="status" name="status"
                                class="block w-full rounded-lg border-slate-300 shadow-sm py-2.5 pl-3 pr-10 text-base focus:border-university-red focus:ring-2 focus:ring-university-red/20 transition-all sm:text-sm">
                                <option>All Statuses</option>
                                @foreach (App\Enums\DocumentStatus::cases() as $status)
                                    <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Results Count & Sorting -->
            <div class="flex justify-between items-center mb-6">
                <p class="text-sm text-slate-600">
                    Showing <span class="font-semibold text-slate-900">25</span> results
                </p>
                <div>
                    <label for="sort" class="sr-only">Sort by</label>
                    <select id="sort" name="sort"
                        class="block w-full rounded-lg border-slate-300 shadow-sm py-1.5 pl-3 pr-10 text-sm focus:border-university-red focus:outline-none focus:ring-2 focus:ring-university-red/50">
                        <option>Date Published</option>
                        <option>Most Relevant</option>
                        <option>Alphabetical</option>
                    </select>
                </div>
            </div>

            <!-- 5x5 Document Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @php
                    $categories = ['Research', 'Thesis', 'Capstone', 'E-Book'];
                    $statuses = \App\Enums\DocumentStatus::cases();
                @endphp

                @for ($i = 1; $i <= 25; $i++)
                    @php
                        $randomStatus = $statuses[array_rand($statuses)];
                    @endphp
                    <x-guest.document-card title="Advanced Engineering Mathematics Vol. {{ $i }}"
                        category="{{ $categories[array_rand($categories)] }}" status="{{ $randomStatus->value }}"
                        statusColor="{{ $randomStatus->color() }}" />
                @endfor
            </div>

            <!-- Pagination Section -->
            <div class="mt-12">
                <x-guest.pagination />
            </div>

        </div>
    </div>
</x-layouts.guest>
