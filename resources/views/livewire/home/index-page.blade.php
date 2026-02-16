<div class="relative w-full overflow-hidden">

    <!-- Background Decorations -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-red-100/50 rounded-full blur-3xl opacity-60">
        </div>
        <div
            class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-gray-200/50 rounded-full blur-3xl opacity-60">
        </div>
    </div>

    <!-- Main Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <!-- Left Content -->
            <div class="space-y-8 animate-slide-up z-10">
                <div
                    class="inline-flex items-center space-x-2 px-4 py-2 bg-red-50 border border-university-red/20 rounded-full">
                    <span class="flex h-2 w-2 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-university-red opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-university-red"></span>
                    </span>
                    <span class="text-university-red text-xs font-bold uppercase tracking-wide">Document
                        Repository</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold text-gray-900 leading-[1.1]">
                        Engineering
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-university-red to-red-700">Knowledge
                            Hub</span>
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed max-w-lg">
                        Access the School of Engineering's vast collection of e-books, research papers, thesis archives,
                        and capstone projects in one secure platform.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    @guest
                        <a href="{{ route('login') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-university-red text-white rounded-xl font-bold text-lg hover:bg-red-900 transition-all duration-300 shadow-lg hover:shadow-red-900/20">
                            Start Reading
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </a>
                    @endguest
                </div>

                <!-- Hub Stats -->
                <div class="grid grid-cols-3 gap-8 pt-8 border-t border-gray-200/60">
                    <div>
                        <div class="text-3xl font-black text-gray-900">500+</div>
                        <div class="text-xs text-gray-500 font-bold uppercase mt-1">Research Papers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900">1k+</div>
                        <div class="text-xs text-gray-500 font-bold uppercase mt-1">E-Books</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-gray-900">Archives</div>
                        <div class="text-xs text-gray-500 font-bold uppercase mt-1">Thesis & Capstone</div>
                    </div>
                </div>
            </div>

            <!-- Right Content -->
            <div class="relative hidden lg:flex justify-center items-center h-full min-h-[500px]">
                <div
                    class="absolute top-10 right-10 w-64 h-80 bg-gray-100 rounded-2xl transform rotate-12 shadow-xl animate-float-delayed z-0 border border-gray-200">
                </div>
                <div
                    class="absolute top-20 left-20 w-64 h-80 bg-gray-50 rounded-2xl transform -rotate-6 shadow-xl animate-float z-10 border border-gray-200">
                </div>

                <div
                    class="relative w-72 h-96 glass-card rounded-2xl shadow-2xl transform rotate-3 animate-float z-20 flex flex-col p-6 border-t-4 border-t-university-red">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-university-red" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="h-2 w-20 bg-gray-200 rounded-full"></div>
                    </div>

                    <div class="space-y-4 flex-grow">
                        <div class="h-4 w-full bg-gray-100 rounded"></div>
                        <div class="h-4 w-5/6 bg-gray-100 rounded"></div>
                        <div class="h-4 w-4/6 bg-gray-100 rounded"></div>
                        <div
                            class="h-32 w-full bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg border border-dashed border-gray-200 mt-4 flex items-center justify-center">
                            <span class="text-gray-300 text-sm">Preview</span>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <div class="h-2 w-16 bg-gray-200 rounded-full"></div>
                        <div class="px-2 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded uppercase">
                            Available
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-20 -right-4 bg-white p-4 rounded-xl shadow-lg animate-bounce z-30">
                    <svg class="w-6 h-6 text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
