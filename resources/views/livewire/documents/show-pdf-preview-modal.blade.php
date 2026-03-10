<div x-show="showPreview" x-cloak @keydown.escape.window="closePreview()" class="fixed inset-0 z-50 overflow-hidden"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">

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
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
            class="relative w-full h-full md:h-[90vh] md:max-w-6xl flex flex-col bg-white md:rounded-lg shadow-2xl overflow-hidden"
            @click.stop>

            <!-- 1. Toolbar Container -->
            <div class="flex-none z-20 border-b border-gray-200 bg-gray-50 min-h-[52px] flex flex-col justify-center">

                <!-- A. STANDARD TOOLBAR -->
                <div x-show="!showMobileSearch" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    class="flex flex-wrap items-center justify-between px-3 py-2 md:px-4 md:py-3 gap-2 w-full">

                    <!-- Left: Close, Title & Resume Badge -->
                    <div class="flex items-center gap-2 mr-auto min-w-0">
                        <button @click="closePreview()"
                            class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <h3 class="text-sm md:text-base font-semibold text-gray-900 truncate max-w-[150px] md:max-w-xs">
                            {{ $modalTitle ?? $document->title }}
                        </h3>
                        {{-- Resume badge — only shown when user was dropped into a saved page --}}
                        <span x-show="_startPage > 1" x-cloak
                            class="hidden md:inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-university-red/10 text-university-red text-xs font-medium">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Resumed p.<span x-text="_startPage"></span>
                        </span>
                    </div>

                    <!-- Right: Controls -->
                    <div class="flex items-center gap-2">

                        <!-- 1. Page Jumper -->
                        <div class="flex items-center bg-white rounded-lg border shadow-sm p-0.5">
                            <button @click="prevPage()"
                                class="p-1.5 hover:bg-gray-100 rounded text-gray-600 disabled:opacity-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <span class="text-xs font-medium text-gray-700 px-2 min-w-[3rem] text-center select-none">
                                <span x-text="page"></span>/<span x-text="numPages"></span>
                            </span>
                            <button @click="nextPage()"
                                class="p-1.5 hover:bg-gray-100 rounded text-gray-600 disabled:opacity-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>

                        <!-- 2. Mobile Search Trigger -->
                        <button @click="showMobileSearch = true; $nextTick(() => $refs.mobileSearchInput.focus())"
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
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="searchQuery" @keydown.enter="performSearch()"
                                    placeholder="Find..."
                                    class="w-32 lg:w-48 border-none text-sm focus:ring-0 placeholder-gray-400 py-1.5 pl-2">
                                <div class="flex border-l bg-gray-50" x-show="searchQuery.length > 0">
                                    <button @click="findPrev()" class="px-2 py-1.5 hover:bg-gray-200 text-gray-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                    <button @click="findNext()" class="px-2 py-1.5 hover:bg-gray-200 text-gray-600">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Desktop Zoom -->
                        <div class="hidden md:flex items-center bg-white rounded-lg border shadow-sm p-1">
                            <button @click="zoomOut()" class="p-1.5 hover:bg-gray-100 rounded text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 12H4" />
                                </svg>
                            </button>
                            <button @click="zoomIn()" class="p-1.5 hover:bg-gray-100 rounded text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </div>

                        <!-- 5. Read Later Toggle -->
                        @auth
                            <button wire:click="toggleReadLater"
                                title="{{ $isInReadLater ? 'Remove from Read Later' : 'Save to Read Later' }}"
                                class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg border text-sm font-medium transition-colors
                                       {{ $isInReadLater
                                           ? 'bg-university-red/10 text-university-red border-university-red/30 hover:bg-university-red/20'
                                           : 'bg-white text-gray-600 border-gray-300 hover:border-university-red hover:text-university-red' }}">
                                <svg class="w-4 h-4 shrink-0" fill="{{ $isInReadLater ? 'currentColor' : 'none' }}"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                {{-- Label hidden on small screens to save toolbar space --}}
                                <span class="hidden md:inline">
                                    {{ $isInReadLater ? 'Saved' : 'Read Later' }}
                                </span>
                            </button>
                        @endauth
                    </div>
                </div>

                <!-- B. MOBILE SEARCH OVERLAY -->
                <div x-show="showMobileSearch" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="w-full bg-white flex items-center px-3 py-2 gap-2 border-b border-gray-200">

                    <button @click="showMobileSearch = false; searchQuery = ''"
                        class="p-2 text-gray-500 hover:text-gray-700 bg-gray-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </button>

                    <div class="flex-1 relative group">
                        <input type="text" x-ref="mobileSearchInput" x-model="searchQuery"
                            @keydown.enter="performSearch()" placeholder="Find in document..."
                            class="w-full bg-gray-100 border-none rounded-lg py-2 pl-3 pr-12 text-sm focus:ring-1 focus:ring-university-red focus:bg-white transition-colors">
                        <span x-show="matchesCount.total > 0"
                            class="absolute right-3 top-2.5 text-xs text-gray-500 font-medium">
                            <span x-text="matchesCount.current"></span>/<span x-text="matchesCount.total"></span>
                        </span>
                    </div>

                    <div class="flex items-center bg-gray-100 rounded-lg p-0.5 border border-gray-200">
                        <button @click="findPrev()"
                            class="p-2 text-gray-600 hover:bg-gray-200 rounded active:bg-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                        <div class="w-px h-4 bg-gray-300 mx-0.5"></div>
                        <button @click="findNext()"
                            class="p-2 text-gray-600 hover:bg-gray-200 rounded active:bg-gray-300">
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

                {{-- PDF.js Container — wire:ignore prevents Livewire DOM morphing from wiping canvases --}}
                <div id="viewerContainer" class="absolute inset-0 overflow-auto" wire:ignore>
                    <div id="viewer" class="pdfViewer"></div>
                </div>

                <!-- Loading Overlay -->
                <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white/90 z-10">
                    <div class="flex flex-col items-center">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-university-red mb-2"></div>
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
