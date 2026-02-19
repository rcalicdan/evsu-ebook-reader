<x-slot name="title">My Profile - DocHub</x-slot>
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
        <p class="mt-2 text-gray-600">Manage your account information and preferences</p>
    </div>

    <!-- Profile Form Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Profile Header with Avatar -->
        <div class="bg-university-red p-6">
            <div class="flex items-center space-x-4">
                <div class="h-20 w-20 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                    <span class="text-3xl font-bold text-university-red">
                        {{ strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1)) }}
                    </span>
                </div>
                <div class="text-white">
                    <h2 class="text-2xl font-bold">{{ $first_name }} {{ $last_name }}</h2>
                    <p class="text-red-100">{{ ucfirst(Auth::user()->role->value) }}</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit="updateProfile" class="p-6 space-y-6">

            <!-- Personal Information Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Personal Information</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="first_name" wire:model="first_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="last_name" wire:model="last_name"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" wire:model="email"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Course -->
                    <div class="md:col-span-2">
                        <label for="course" class="block text-sm font-medium text-gray-700 mb-2">
                            Course / Program <span class="text-red-500">*</span>
                        </label>
                        <select id="course" wire:model="course"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('course') border-red-500 @enderror">
                            <option value="" disabled>— Select your program —</option>
                            @foreach ($courses as $c)
                                <option value="{{ $c->value }}">{{ $c->label() }}</option>
                            @endforeach
                        </select>
                        @error('course')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Student Information Section (Only for Students) -->
            @if (Auth::user()->isStudent())
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Student Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student ID -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Student ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="student_id" wire:model="student_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('student_id') border-red-500 @enderror">
                            @error('student_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <!-- Password Section -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Change Password</h3>

                <div class="grid grid-cols-1 gap-6">
                    <!-- Current Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Password
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="current_password"
                                wire:model="current_password"
                                class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('current_password') border-red-500 @enderror"
                                placeholder="Enter current password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="new_password"
                                wire:model="new_password"
                                class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition @error('new_password') border-red-500 @enderror"
                                placeholder="Enter new password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div x-data="{ showPassword: false }">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password
                        </label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="new_password_confirmation"
                                wire:model="new_password_confirmation"
                                class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-university-red focus:border-transparent transition"
                                placeholder="Confirm new password">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-gray-800 transition">
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                @php
                    $user = auth()->user();

                    $intendedRoute = match (true) {
                        $user->isSuperAdmin(), $user->isAdmin() => route('dashboard.index'),
                        default => route('documents.index'),
                    };
                @endphp

                <a href="{{ $intendedRoute }}" wire:navigate
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled"
                    class="px-6 py-2 bg-university-red text-white rounded-lg font-medium hover:bg-red-700 transition shadow-md disabled:opacity-75 disabled:cursor-not-wait inline-flex items-center">
                    <span wire:loading.remove wire:target="updateProfile">Save Changes</span>
                    <span wire:loading wire:target="updateProfile" class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Saving...
                    </span>
                </button>
            </div>

        </form>
    </div>
</div>