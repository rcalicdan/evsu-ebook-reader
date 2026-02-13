<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Logs</h1>
            <p class="text-sm text-gray-500">Monitor all system activities and changes.</p>
        </div>
    </div>

    <!-- Main Table Section -->
    <x-table.index>
        <!-- Search & Filters -->
        <x-table.header>
            <div class="flex flex-col md:flex-row gap-3 w-full">
                <!-- Search -->
                <div class="relative flex-1 min-w-0">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search audit logs..."
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Filters -->
                <div class="flex flex-col md:flex-row gap-2 md:shrink-0">
                    <!-- Event Filter -->
                    <select wire:model.live="eventFilter"
                        class="w-full md:w-32 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Events</option>
                        @foreach ($events as $event)
                            <option value="{{ $event }}">{{ ucfirst($event) }}</option>
                        @endforeach
                    </select>

                    <!-- Model Type Filter -->
                    <select wire:model.live="auditableTypeFilter"
                        class="w-full md:w-36 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Models</option>
                        @foreach ($auditableTypes as $type)
                            <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                        @endforeach
                    </select>

                    <!-- Date Filter -->
                    <select wire:model.live="dateFilter"
                        class="w-full md:w-36 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-600 focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="yesterday">Yesterday</option>
                        <option value="last_7_days">Last 7 Days</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="this_month">This Month</option>
                        <option value="last_month">Last Month</option>
                    </select>
                </div>
            </div>
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header>ID</x-table.cell>
                    <x-table.cell header>Event</x-table.cell>
                    <x-table.cell header>Model</x-table.cell>
                    <x-table.cell header>User</x-table.cell>
                    <x-table.cell header>Changes</x-table.cell>
                    <x-table.cell header class="text-center">Date</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($auditLogs as $log)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $log->id }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <x-ui.badge :variant="match($log->event) {
                                    'created' => 'success',
                                    'updated' => 'info',
                                    'deleted' => 'danger',
                                    'attached', 'synced' => 'warning',
                                    'detached' => 'secondary',
                                    default => 'primary'
                                }">
                                    {{ $log->formatted_event }}
                                </x-ui.badge>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ $log->auditable_type_name }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        ID: {{ $log->auditable_id }}
                                    </span>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                @if ($log->user)
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-university-red/10 flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-medium text-university-red">
                                                {{ substr($log->user->first_name, 0, 1) }}{{ substr($log->user->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $log->user->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 truncate">{{ $log->user->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400 italic">System</span>
                                @endif
                            </x-table.cell>

                            <x-table.cell>
                                <div class="text-xs">
                                    @if ($log->old_values && count($log->old_values) > 0)
                                        <span class="text-gray-600">
                                            {{ count($log->old_values) }} field(s) changed
                                        </span>
                                    @elseif($log->new_values && count($log->new_values) > 0)
                                        <span class="text-gray-600">
                                            {{ count($log->new_values) }} field(s) set
                                        </span>
                                    @else
                                        <span class="text-gray-400">No changes</span>
                                    @endif
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="text-center">
                                    <p class="text-xs text-gray-500">{{ $log->created_at->format('M d, Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $log->created_at->format('g:i A') }}</p>
                                </div>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    <x-ui.view-button :href="route('audit-logs.show', $log)" />
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-gray-500 font-medium text-lg">No audit logs found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </table>
        </div>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$auditLogs" />
    </x-table.index>
</div>