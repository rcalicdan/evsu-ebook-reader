<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
            <p class="text-sm text-gray-500">Manage university accounts and administrative access levels.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button variant="primary" href="{{ route('users.create') }}">
                <x-slot:icon>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </x-slot:icon>
                Add New User
            </x-ui.button>
        </div>
    </div>

    <x-table.index>
        <x-table.header searchable>
            <x-slot:filters>
                <select
                    class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-xl px-4 py-2.5 focus:border-university-red outline-none">
                    <option>All Roles</option>
                    <option>Students</option>
                    <option>Admins</option>
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
                                    <x-ui.avatar :name="$user->name" :variant="$user->role === 'admin' ? 'secondary' : 'primary'" />
                                    <span class="ml-3 font-bold text-gray-900">{{ $user->name }}</span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="text-gray-600 font-medium">{{ $user->email }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <x-ui.badge :variant="$user->role === 'admin' ? 'primary' : 'info'">
                                    {{ ucfirst($user->role) }}
                                </x-ui.badge>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
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

                                    <x-ui.button variant="danger" size="sm"
                                        onclick="confirm('Are you sure you want to delete this user?') || event.stopImmediatePropagation()"
                                        wire:click="deleteUser({{ $user->id }})">
                                        <x-slot:icon>
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </x-slot:icon>
                                        Delete
                                    </x-ui.button>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="text-center py-8 text-gray-500">
                                No users found.
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
