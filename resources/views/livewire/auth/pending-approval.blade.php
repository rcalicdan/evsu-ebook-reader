<div class="w-full max-w-md mx-auto px-4">
    <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
        <x-auth.header />

        <div class="px-5 py-8 sm:px-10 text-center space-y-4">
            <!-- Icon -->
            <div class="flex justify-center">
                <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-900">Account Pending Approval</h2>
            <p class="text-sm text-gray-500">
                Your account has been registered successfully. Please wait for an administrator to approve your account
                before you can access the system.
            </p>

            <a wire:navigate href="{{ route('login') }}"
                class="inline-flex items-center gap-2 text-sm font-semibold text-university-red hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14" />
                </svg>
                Back to Login
            </a>
        </div>
    </div>

    <x-auth.footer />
</div>
