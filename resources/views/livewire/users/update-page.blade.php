<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit User Account</h1>
            <p class="text-sm text-gray-500">Update profile details and system permissions for this user.</p>
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

    <!-- Edit Account Card -->
    <form wire:submit.prevent="update">
        <x-form.card>
            <!-- Custom Header with Badge -->
            <x-slot:title>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">User Information</h3>
                        <p class="text-sm text-gray-500 font-normal mt-1">Modify the fields below to update the account.
                        </p>
                    </div>
                    <x-ui.badge variant="success">
                        Active Account
                    </x-ui.badge>
                </div>
            </x-slot:title>

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
                        Update Account
                    </x-ui.button>
                </div>
            </x-slot:footer>

            <!-- Name Row -->
            <x-form.grid cols="2">
                <div>
                    <x-form.label for="first_name" required>First Name</x-form.label>
                    <x-form.input type="text" id="first_name" wire:model="first_name" placeholder="John"
                        :error="$errors->first('first_name')" />
                </div>

                <div>
                    <x-form.label for="last_name" required>Last Name</x-form.label>
                    <x-form.input type="text" id="last_name" wire:model="last_name" placeholder="Doe"
                        :error="$errors->first('last_name')" />
                </div>
            </x-form.grid>

            <!-- Email & Role Row -->
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
                        <option value="student">Student</option>
                        <option value="admin">Admin</option>
                        <option value="superadmin">Super Admin</option>
                    </x-form.select>
                </div>
            </x-form.grid>

            <!-- Password Section (Optional on Update) -->
            <x-form.section title="Reset Password" description="Leave this field blank to keep the current password">
                <x-form.grid cols="2">
                    <div>
                        <x-form.label for="password">New Password</x-form.label>
                        <x-form.input type="password" id="password" wire:model="password" placeholder="••••••••••••"
                            :error="$errors->first('password')">
                            <x-slot:icon>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </x-slot:icon>
                        </x-form.input>
                    </div>

                    <div>
                        <x-form.label for="password_confirmation">Confirm New Password</x-form.label>
                        <x-form.input type="password" id="password_confirmation" wire:model="password_confirmation"
                            placeholder="••••••••••••" :error="$errors->first('password_confirmation')">
                            <x-slot:icon>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </x-slot:icon>
                        </x-form.input>
                    </div>
                </x-form.grid>
            </x-form.section>
        </x-form.card>
    </form>
</div>
