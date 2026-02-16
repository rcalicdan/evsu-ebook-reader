<div class="w-full bg-slate-50 min-h-screen">
    @guest
        <!-- Login Required Section for Guests -->
        <div class="relative w-full overflow-hidden py-16 md:py-24">
            <!-- Background Decorations -->
            <div class="absolute inset-0 pointer-events-none">
                <div
                    class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-red-100/50 rounded-full blur-3xl opacity-60">
                </div>
                <div
                    class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-gray-200/50 rounded-full blur-3xl opacity-60">
                </div>
            </div>

            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Lock Icon -->
                <div class="flex justify-center mb-8">
                    <div class="relative">
                        <div
                            class="w-32 h-32 bg-university-red/10 rounded-full flex items-center justify-center animate-pulse">
                            <svg class="w-16 h-16 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-yellow-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Main Message -->
                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-4">
                    Login Required to View Documents
                </h1>

                <p class="text-xl text-slate-600 mb-2 max-w-2xl mx-auto">
                    Access to our document repository is restricted to authenticated users only.
                </p>

                <p class="text-base text-slate-500 mb-8 max-w-xl mx-auto">
                    Please log in with your EVSU account to browse, search, and view our collection of research papers,
                    e-books, thesis archives, and capstone projects.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a wire:navigate href="{{ route('login') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-university-red text-white rounded-xl font-bold text-lg hover:bg-university-red/90 transition-colors shadow-lg hover:shadow-university-red/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login to Continue
                    </a>

                    <a wire:navigate href="{{ route('home') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-slate-700 border-2 border-slate-300 rounded-xl font-bold text-lg hover:bg-slate-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Back to Home
                    </a>
                </div>

                <!-- Benefits Section -->
                <div class="mt-16 pt-8 border-t border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8">What you'll get access to:</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-lg mb-2">Browse Documents</h3>
                            <p class="text-sm text-slate-600">Access thousands of research papers, e-books, thesis archives,
                                and capstone projects</p>
                        </div>

                        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-lg mb-2">Advanced Search</h3>
                            <p class="text-sm text-slate-600">Find exactly what you need with powerful search and filtering
                                tools</p>
                        </div>

                        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 text-lg mb-2">Preview & Read</h3>
                            <p class="text-sm text-slate-600">View documents online with our integrated PDF reader</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest

    @auth
        <!-- Full Table Page for Authenticated Users -->
        <!-- Page Header -->
        <header class="bg-gradient-to-b from-white to-slate-50 border-b border-slate-200 py-16 text-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <span class="flex h-2 w-2 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-university-red opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-university-red"></span>
                    </span>
                    <span class="text-university-red text-xs font-bold uppercase tracking-wide">Welcome back,
                        {{ auth()->user()->first_name }}!</span>
                </div>
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
                                <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.500ms="search" id="search"
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
                        <select wire:model.live="category" id="category"
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
                        <select wire:model.live="status" id="status"
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
                    <select wire:model.live="sort" id="sort"
                        class="block w-full rounded-lg border-slate-300 shadow-sm py-1.5 pl-3 pr-10 text-sm focus:border-university-red focus:outline-none focus:ring-2 focus:ring-university-red/50">
                        <option value="latest">Date Published</option>
                        <option value="popular">Most Popular</option>
                        <option value="alphabetical">Alphabetical</option>
                    </select>
                </div>
            </div>

            <!-- Document Grid -->
            @if ($documents->count())
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
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">No documents found</h3>
                    <p class="mt-1 text-sm text-slate-500">Try adjusting your search or filters.</p>
                </div>
            @endif

        </div>
    @endauth
</div>
