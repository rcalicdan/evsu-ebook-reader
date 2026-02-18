<div class="login-container" style="max-width: 480px; margin: auto;">
    <x-auth.header />

    <div class="form-content" style="padding: 20px 28px;">
        <form wire:submit="register">

            <!-- Full Name -->
            <div class="form-group" style="margin-bottom: 12px;">
                <label for="name">Full Name</label>
                <input type="text" id="name" wire:model="name" placeholder="Juan Dela Cruz"
                    class="@error('name') error @enderror" required autofocus>
                @error('name')
                    <div class="error-message">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Course -->
            <div class="form-group" style="margin-bottom: 12px;">
                <label for="course">Course / Program</label>
                <div class="mb-1 inline-flex items-center gap-1.5 rounded-full bg-university-red/10 px-3 py-0.5">
                    <svg class="w-3.5 h-3.5 text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422A12.083 12.083 0 0121 21H3a12.083 12.083 0 012.84-10.422L12 14z" />
                    </svg>
                    <span class="text-xs font-semibold text-university-red uppercase tracking-wide">School of Engineering</span>
                </div>
                <div class="relative">
                    <select id="course" wire:model="course"
                        class="w-full appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2.5 pr-10 text-sm text-gray-800 shadow-sm transition-all duration-200 hover:border-university-red/50 focus:border-university-red focus:outline-none focus:ring-2 focus:ring-university-red/20 @error('course') border-red-500 ring-2 ring-red-200 @enderror"
                        required>
                        <option value="" disabled selected>— Select your program —</option>
                        <option value="BSChE">BS Chemical Engineering (BSChE)</option>
                        <option value="BSCE">BS Civil Engineering (BSCE)</option>
                        <option value="BSEE">BS Electrical Engineering (BSEE)</option>
                        <option value="BSECE">BS Electronics & Communications Engineering (BSECE)</option>
                        <option value="BSGE">BS Geodetic Engineering (BSGE)</option>
                        <option value="BSIE">BS Industrial Engineering (BSIE)</option>
                        <option value="BSIT">BS Information Technology (BSIT)</option>
                        <option value="BSME">BS Mechanical Engineering (BSME)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                        <div class="flex items-center justify-center w-6 h-6 rounded-full bg-university-red/10">
                            <svg class="w-3.5 h-3.5 text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>
                @error('course')
                    <div class="error-message">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group" style="margin-bottom: 12px;">
                <label for="email">Email Address</label>
                <input type="email" id="email" wire:model="email" placeholder="your.name@evsu.edu.ph"
                    class="@error('email') error @enderror" required>
                @error('email')
                    <div class="error-message">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group" style="margin-bottom: 12px;" x-data="{ showPassword: false }">
                <label for="password">Password</label>
                <div class="password-input-wrapper">
                    <input :type="showPassword ? 'text' : 'password'" id="password" wire:model="password"
                        placeholder="••••••••" class="@error('password') error @enderror" required>
                    <button type="button" @click="showPassword = !showPassword" class="password-toggle-btn">
                        <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="error-message">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group" style="margin-bottom: 12px;" x-data="{ showConfirm: false }">
                <label for="password_confirmation">Confirm Password</label>
                <div class="password-input-wrapper">
                    <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation"
                        wire:model="password_confirmation" placeholder="••••••••"
                        class="@error('password_confirmation') error @enderror" required>
                    <button type="button" @click="showConfirm = !showConfirm" class="password-toggle-btn">
                        <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="error-message">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="login-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">Create Account</span>
                <span wire:loading wire:target="register">
                    <span class="spinner"></span>
                    Creating account...
                </span>
            </button>

            <!-- Divider -->
            <div class="relative my-3">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-xs text-gray-400">
                    <span class="bg-white px-3">Already have an account?</span>
                </div>
            </div>

            <!-- Link to Login -->
            <a wire:navigate href="{{ route('login') }}"
                class="flex w-full items-center justify-center gap-2 rounded-lg border border-university-red/30 bg-university-red/5 px-4 py-2 text-sm font-semibold text-university-red transition-all duration-200 hover:bg-university-red/10 hover:border-university-red/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Sign in to your account
            </a>

        </form>
    </div>

    <x-auth.footer />
</div>