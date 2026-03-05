<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Read Later</h1>
            <p class="mt-2 text-sm text-gray-600">Documents you've saved to read later</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button class="border-university-red text-university-red whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    All (12)
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Unread (5)
                </button>
            </nav>
        </div>

        {{-- Documents List --}}
        <div class="space-y-4">
            {{-- Document Item 1 (Unread) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    {{-- Status Icon --}}
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    {{-- Document Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-university-red cursor-pointer">
                                    Research Paper on Machine Learning Algorithms
                                </h3>
                                <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Computer Science
                                    </span>
                                    <span>•</span>
                                    <span>Added 2 days ago</span>
                                </div>
                            </div>

                            {{-- Document Type Badge --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                PDF
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex items-center gap-3">
                            <button class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Mark as Read
                            </button>
                            <span class="text-gray-300">|</span>
                            <span class="text-gray-300">|</span>
                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                View Document
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Item 2 (Read) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow opacity-75">
                <div class="flex items-start gap-4">
                    {{-- Status Icon (Read) --}}
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    {{-- Document Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-university-red cursor-pointer">
                                    Student Handbook 2024
                                </h3>
                                <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Policies
                                    </span>
                                    <span>•</span>
                                    <span>Added 1 week ago</span>
                                    <span>•</span>
                                    <span class="text-green-600">Read 3 days ago</span>
                                </div>
                            </div>

                            {{-- Document Type Badge --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                DOCX
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex items-center gap-3">
                            <button class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mark as Unread
                            </button>
                            <span class="text-gray-300">|</span>
                            
                            <span class="text-gray-300">|</span>
                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                View Document
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Item 3 (Unread) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    {{-- Status Icon --}}
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    {{-- Document Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-university-red cursor-pointer">
                                    Course Syllabus - Web Development
                                </h3>
                                <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Academic
                                    </span>
                                    <span>•</span>
                                    <span>Added 5 hours ago</span>
                                </div>
                            </div>

                            {{-- Document Type Badge --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                PDF
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex items-center gap-3">
                            <button class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Mark as Read
                            </button>
                            <span class="text-gray-300">|</span>
        
                            <span class="text-gray-300">|</span>
                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                View Document
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Document Item 4 (Unread) --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4">
                    {{-- Status Icon --}}
                    <div class="flex-shrink-0 mt-1">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    {{-- Document Info --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 hover:text-university-red cursor-pointer">
                                    Thesis Guidelines and Templates
                                </h3>
                                <div class="mt-1 flex items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        Research
                                    </span>
                                    <span>•</span>
                                    <span>Added yesterday</span>
                                </div>
                            </div>

                            {{-- Document Type Badge --}}
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ZIP
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="mt-4 flex items-center gap-3">
                            <button class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-800 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Mark as Read
                            </button>
                            <span class="text-gray-300">|</span>
                            
                            <span class="text-gray-300">|</span>
                            <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                View Document
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Empty State (show this when no documents, currently hidden) --}}
        <div class="hidden bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No documents saved</h3>
            <p class="mt-2 text-sm text-gray-500">Start saving documents to read them later</p>
            <div class="mt-6">
                <a href="{{ route('documents.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-university-red hover:bg-red-800">
                    Browse Documents
                </a>
            </div>
        </div>
    </div>
</div>