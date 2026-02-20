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
                    <x-table.cell header sortable sortField="id">ID</x-table.cell>
                    <x-table.cell header sortable sortField="first_name">Full Name</x-table.cell>
                    <x-table.cell header sortable sortField="email">Email Address</x-table.cell>
                    <x-table.cell header sortable sortField="role">System Role</x-table.cell>
                    <x-table.cell header>Status</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($users as $user)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $user->id }}</span>
                            </x-table.cell>

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
                                @if ($user->isAdmin() || $user->isSuperAdmin())
                                    <x-ui.badge variant="success">Active</x-ui.badge>
                                @elseif ($user->isStudent())
                                    @if ($user->is_rejected)
                                        <x-ui.badge variant="danger">Rejected</x-ui.badge>
                                    @elseif ($user->is_approved)
                                        <x-ui.badge variant="success">Active</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="warning">Pending</x-ui.badge>
                                    @endif
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    @can('update', $user)
                                        @if ($user->isStudent() && !$user->is_approved && !$user->is_rejected)
                                            <button
                                                wire:click="approveUser({{ $user->id }})"
                                                wire:confirm="Are you sure you want to approve {{ $user->full_name }}?"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                        @endif
                                        <x-ui.edit-button :href="route('users.edit', $user)" />
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
                            <x-table.cell colspan="6" class="text-center py-8">
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