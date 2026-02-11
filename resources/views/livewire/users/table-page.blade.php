<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-sm text-gray-500">Manage university accounts and administrative access levels.</p>
        </div>
        <div class="flex items-center gap-3">
            @can('create', \App\Models\User::class)
                <x-ui.button variant="primary" href="{{ route('users.create') }}">
                    <x-slot:icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </x-slot:icon>
                    Add New User
                </x-ui.button>
            @endcan
        </div>
    </div>

    <!-- Main Table Section -->
    <x-table.index>
        <!-- Search & Filters -->
        <x-table.header>
            <div class="relative w-full md:w-96">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or email..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <x-slot:filters>
                <select wire:model.live="roleFilter"
                    class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-xl px-4 py-2.5 focus:border-university-red outline-none">
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </x-slot:filters>
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header>Full Name</x-table.cell>
                    <x-table.cell header>Email Address</x-table.cell>
                    <x-table.cell header>System Role</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($users as $user)
                        <x-table.row>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <x-ui.avatar :name="$user->full_name" :variant="$user->isAdmin() || $user->isSuperAdmin() ? 'secondary' : 'primary'" />
                                    <span class="ml-3 font-bold text-gray-900">{{ $user->full_name }}</span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="text-gray-600 font-medium">{{ $user->email }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                @php
                                    $badgeVariant = match ($user->role->value) {
                                        'superadmin' => 'primary',
                                        'admin' => 'warning',
                                        'student' => 'info',
                                        default => 'info',
                                    };
                                @endphp
                                <x-ui.badge :variant="$badgeVariant">
                                    {{ $user->role->label() }}
                                </x-ui.badge>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    @can('update', $user)
                                        <x-ui.button variant="success" size="sm"
                                            href="{{ route('users.edit', $user) }}">
                                            <x-slot:icon>
                                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </x-slot:icon>
                                            Edit
                                        </x-ui.button>
                                    @endcan

                                    @can('delete', $user)
                                        <x-ui.delete-button :id="$user->id" :name="$user->full_name" resource="User"
                                            wire="deleteUser" />
                                    @endcan
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No users found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filters</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </table>
        </div>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$users" />
    </x-table.index>
</div>
