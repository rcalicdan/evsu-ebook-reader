<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit User Account</h1>
            <p class="text-sm text-gray-500">Update profile details and system permissions for this user.</p>
        </div>
        <!-- Back to Directory -->
        <a href="{{ route('users.index') }}" class="text-university-red text-sm font-bold hover:underline flex items-center transition-all">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Directory
        </a>
    </div>

    <!-- Edit Account Card (Matches Table/Create Design) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        
        <!-- Header Style Matches Table -->
        <div class="p-6 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
            <div>
                <h3 class="text-lg font-bold text-gray-800">User Information</h3>
                <p class="text-sm text-gray-500">Modify the fields below to update the account.</p>
            </div>
            <!-- Status Badge -->
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-50 text-green-700 border border-green-100">
                Active Account
            </span>
        </div>

        <!-- Form Body -->
        <form wire:submit.prevent="update">
            <div class="p-6 space-y-6">
                
                <!-- Name Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2">First Name</label>
                        <input type="text" wire:model="first_name" placeholder="John" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none">
                        @error('first_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2">Last Name</label>
                        <input type="text" wire:model="last_name" placeholder="Doe" required
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none">
                        @error('last_name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Email & Role Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2">Email Address</label>
                        <div class="relative">
                            <input type="email" wire:model="email" placeholder="name@university.edu" required
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2">System Role</label>
                        <select wire:model="role" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            <option value="student">Student</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                        @error('role') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Password Section (Optional on Update) -->
                <div class="pt-4 border-t border-gray-50">
                    <label class="block text-[11px] uppercase tracking-widest font-bold text-gray-400 mb-2">Reset Password</label>
                    <div class="relative w-full md:w-1/2">
                        <input type="password" wire:model="password" placeholder="••••••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all outline-none">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <p class="mt-2 text-xs text-gray-400 italic">Leave this field blank to keep the current password.</p>
                    @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Footer Actions Matches Pagination Style -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-university-red text-white rounded-lg text-sm font-bold hover:bg-red-700 transition shadow-md shadow-red-100 active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Update Account
                </button>
            </div>
        </form>
    </div>
</div>