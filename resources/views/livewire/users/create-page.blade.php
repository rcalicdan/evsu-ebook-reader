<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Account Creation</h1>
            <p class="text-sm text-gray-500">Register a new user and assign system permissions.</p>
        </div>
        <x-ui.button variant="secondary" size="sm" href="{{ route('users.index') }}">
            <x-slot:icon>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </x-slot:icon>
            Back to Directory
        </x-ui.button>
    </div>

    <!-- Add Account Card -->
    <form wire:submit.prevent="save">
        <x-form.card title="User Information" description="Fill in the primary details to create the user profile.">
            <x-slot:footer>
                <div class="flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" href="{{ route('users.index') }}">
                        Cancel
                    </x-ui.button>

                    <x-ui.button type="submit" variant="primary">
                        <x-slot:icon>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </x-slot:icon>
                        Create Account
                    </x-ui.button>
                </div>
            </x-slot:footer>

            <!-- Name Row -->
            <x-form.grid cols="2">
                <div>
                    <x-form.label for="first_name" required>First Name</x-form.label>
                    <x-form.input type="text" id="first_name" wire:model="first_name" placeholder="e.g. John"
                        :error="$errors->first('first_name')" />
                </div>

                <div>
                    <x-form.label for="last_name" required>Last Name</x-form.label>
                    <x-form.input type="text" id="last_name" wire:model="last_name" placeholder="e.g. Doe"
                        :error="$errors->first('last_name')" />
                </div>
            </x-form.grid>

            <!-- Contact & Role Row -->
            <x-form.grid cols="2">
                <div>
                    <x-form.label for="email" required>Email Address</x-form.label>
                    <x-form.input type="email" id="email" wire:model="email" placeholder="name@university.edu"
                        :error="$errors->first('email')">
                        <x-slot:icon>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </x-slot:icon>
                    </x-form.input>
                </div>

                <div>
                    <x-form.label for="role" required>System Role</x-form.label>
                    <x-form.select id="role" wire:model="role" placeholder="Select Role" :error="$errors->first('role')">
                        @foreach ($roles as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </x-form.select>
                </div>
            </x-form.grid>

            <!-- Password Section -->
            <x-form.section title="Security Password" description="Set a secure password for the user account">
                <x-form.grid cols="2">
                    <div>
                        <x-form.label for="password" required>Password</x-form.label>
                        <x-form.input type="password" id="password" wire:model="password" placeholder="••••••••••••"
                            :error="$errors->first('password')" x-data="{ show: false }">
                            <x-slot:icon>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </x-slot:icon>
                            <x-slot:toggleIcon>
                                <button type="button" @click="show = !show" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </x-slot:toggleIcon>
                        </x-form.input>
                    </div>

                    <div>
                        <x-form.label for="password_confirmation" required>Confirm Password</x-form.label>
                        <x-form.input type="password" id="password_confirmation" wire:model="password_confirmation"
                            placeholder="••••••••••••" :error="$errors->first('password_confirmation')" x-data="{ show: false }">
                            <x-slot:icon>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </x-slot:icon>
                            <x-slot:toggleIcon>
                                <button type="button" @click="show = !show" class="text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </x-slot:toggleIcon>
                        </x-form.input>
                    </div>
                </x-form.grid>
            </x-form.section>
        </x-form.card>
    </form>
</div>