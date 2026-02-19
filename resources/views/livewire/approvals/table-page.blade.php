<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Account Approvals</h1>
            <p class="text-sm text-gray-500">Review and approve pending student account registrations.</p>
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

            @if (count($courses) > 0)
                <x-slot:filters>
                    <select wire:model.live="courseFilter"
                        class="bg-gray-50 border border-gray-200 text-gray-600 text-sm rounded-xl px-4 py-2.5 focus:border-university-red outline-none">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->value }}">{{ $course->value }}</option>
                        @endforeach
                    </select>
                </x-slot:filters>
            @endif
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header sortable sortField="id">ID</x-table.cell>
                    <x-table.cell header sortable sortField="first_name">Full Name</x-table.cell>
                    <x-table.cell header sortable sortField="email">Email Address</x-table.cell>
                    <x-table.cell header sortable sortField="course">Course</x-table.cell>
                    <x-table.cell header>Student ID</x-table.cell>
                    <x-table.cell header sortable sortField="created_at">Registered</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse ($users as $user)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $user->id }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center gap-3">
                                    <x-ui.avatar :name="$user->full_name" />
                                    <span class="font-bold text-gray-900">{{ $user->full_name }}</span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="text-gray-600 font-medium">{{ $user->email }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                @if ($user->course)
                                    <x-ui.badge variant="info">{{ $user->course->value }}</x-ui.badge>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </x-table.cell>

                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">
                                    {{ $user->studentProfile?->student_id ?? '—' }}
                                </span>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="text-gray-500 text-sm">
                                    {{ $user->created_at->diffForHumans() }}
                                </span>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center">
                                    <x-ui.approve-button :id="$user->id" :name="$user->full_name" wire="approve" />
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="7" class="text-center py-8">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No pending approvals</p>
                                    <p class="text-gray-400 text-sm mt-1">All accounts have been reviewed.</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </table>
        </div>

        <x-ui.pagination :paginator="$users" />
    </x-table.index>
</div>
