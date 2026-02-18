<div class="login-container">
    <x-auth.header />

    <div class="form-content">
        <form wire:submit="login">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" wire:model="email" placeholder="your.name@evsu.edu.ph"
                    class="@error('email') error @enderror" required autofocus>
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

            <div class="form-group" x-data="{ showPassword: false }">
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

            <button type="submit" class="login-btn" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">Sign In</span>
                <span wire:loading wire:target="login">
                    <span class="spinner"></span>
                    Signing in...
                </span>
            </button>

            <!-- Link to Register -->
            <p class="mt-4 text-center text-sm text-gray-500">
                Don't have an account?
                <a wire:navigate href="{{ route('register') }}" class="text-university-red font-semibold hover:underline">
                    Register here
                </a>
            </p>

        </form>
    </div>

    <x-auth.footer />
</div>