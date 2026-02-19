<div class="w-full max-w-md mx-auto px-4">
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
        
        <x-auth.header />

        <div class="px-6 py-8 sm:px-10 sm:py-10">

            <!-- Status Icon -->
            <div class="flex justify-center mb-6">
                <div class="relative">
                    <div class="w-20 h-20 rounded-full bg-yellow-50 border-4 border-yellow-100 flex items-center justify-center relative z-10">
                        <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <!-- Pulse Ring -->
                    <span class="absolute inset-0 rounded-full animate-ping bg-yellow-200 opacity-50"></span>
                </div>
            </div>

            <!-- Text Content -->
            <div class="text-center space-y-3 mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Pending Approval</h2>
                <p class="text-sm text-gray-500 leading-relaxed mx-auto px-2">
                    Your account has been registered successfully. An administrator will review and approve your account shortly.
                </p>
            </div>

            <!-- Info Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-8">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-6 h-6 mt-0.5">
                        <svg class="w-full h-full text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-bold text-yellow-800 uppercase tracking-wide">What happens next?</p>
                        <p class="text-xs text-yellow-700 leading-relaxed text-justify">
                            Once approved, you can log in to access the document repository. This typically takes up to 24 hours.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="flex items-center justify-between gap-4 mb-6">
                <div class="h-px bg-gray-200 flex-1"></div>
                <!-- Updated text to match the new button destination -->
                <span class="text-xs text-gray-400 font-medium whitespace-nowrap">return to main site</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <!-- Back to Home Button (Updated Size & Route) -->
            <a href="{{ route('home') }}"
                class="group flex w-full items-center justify-center gap-3 rounded-xl border border-university-red/30 bg-university-red/5 px-6 py-4 text-lg font-bold text-university-red transition-all duration-200 hover:bg-university-red hover:text-white hover:border-university-red shadow-sm hover:shadow-lg hover:-translate-y-0.5">
                
                <!-- Home Icon -->
                <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                
                Back to Home
            </a>

        </div>
    </div>

    <x-auth.footer />
</div>