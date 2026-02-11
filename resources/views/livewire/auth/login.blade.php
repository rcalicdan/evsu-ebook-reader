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

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" wire:model="password" placeholder="••••••••"
                    class="@error('password') error @enderror" required>
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
        </form>
    </div>

    <x-auth.footer />
</div>
