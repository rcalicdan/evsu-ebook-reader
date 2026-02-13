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
            <div class="flex flex-col gap-3 w-full">
                <!-- First Row: Search + Basic Filters -->
                <div class="flex flex-col md:flex-row gap-3">
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
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>

                <!-- Second Row: Custom Date Range (shown when custom is selected or dates are set) -->
                @if ($dateFilter === 'custom' || $dateFrom || $dateTo)
                    <div class="flex flex-col gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <!-- Date Inputs Row -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">From Date</label>
                                <input type="date" wire:model.live="dateFrom"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700 mb-1.5">To Date</label>
                                <input type="date" wire:model.live="dateTo"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                            </div>
                        </div>

                        <!-- Time Filters Toggle & Inputs -->
                        <div class="flex flex-col gap-3">
                            <button wire:click="toggleTimeFilters" type="button"
                                class="self-start text-xs text-university-red hover:text-university-red/80 font-medium transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 transition-transform {{ $showTimeFilters ? 'rotate-90' : '' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                {{ $showTimeFilters ? 'Hide time filters' : 'Add time filters (optional)' }}
                            </button>

                            @if ($showTimeFilters)
                                <div class="flex flex-col sm:flex-row gap-3 pl-5 border-l-2 border-university-red/20">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-600 mb-1.5">From Time</label>
                                        <input type="time" wire:model.live="timeFrom"
                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                                        <p class="text-xs text-gray-500 mt-1">Defaults to 00:00 if not set</p>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-600 mb-1.5">To Time</label>
                                        <input type="time" wire:model.live="timeTo"
                                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red outline-none transition-all">
                                        <p class="text-xs text-gray-500 mt-1">Defaults to 23:59 if not set</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end pt-2 border-t border-gray-200">
                            <button wire:click="clearDateRange" type="button"
                                class="px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                                Clear All Date Filters
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Active Filters Display -->
                @if ($search || $eventFilter || $auditableTypeFilter || $dateFilter || $dateFrom || $dateTo)
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-xs text-gray-500 font-medium">Active filters:</span>

                        @if ($search)
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-university-red/10 text-university-red rounded-md text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                "{{ Str::limit($search, 20) }}"
                                <button wire:click="$set('search', '')" class="hover:text-university-red/70 ml-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        @endif

                        @if ($eventFilter)
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-university-red/10 text-university-red rounded-md text-xs font-medium">
                                Event: {{ ucfirst($eventFilter) }}
                                <button wire:click="$set('eventFilter', '')"
                                    class="hover:text-university-red/70 ml-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        @endif

                        @if ($auditableTypeFilter)
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-university-red/10 text-university-red rounded-md text-xs font-medium">
                                Model: {{ class_basename($auditableTypeFilter) }}
                                <button wire:click="$set('auditableTypeFilter', '')"
                                    class="hover:text-university-red/70 ml-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        @endif

                        @if ($dateFrom || $dateTo)
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-university-red/10 text-university-red rounded-md text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                @if ($dateFrom && $dateTo)
                                    {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
                                    @if ($timeFrom)
                                        {{ \Carbon\Carbon::parse($timeFrom)->format('g:i A') }}
                                    @endif
                                    →
                                    {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                                    @if ($timeTo)
                                        {{ \Carbon\Carbon::parse($timeTo)->format('g:i A') }}
                                    @endif
                                @elseif($dateFrom)
                                    From: {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
                                    @if ($timeFrom)
                                        {{ \Carbon\Carbon::parse($timeFrom)->format('g:i A') }}
                                    @endif
                                @else
                                    To: {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                                    @if ($timeTo)
                                        {{ \Carbon\Carbon::parse($timeTo)->format('g:i A') }}
                                    @endif
                                @endif
                                <button wire:click="clearDateRange" class="hover:text-university-red/70 ml-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </x-table.header>

        <!-- Table (same as before) -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header sortable sortField="id">ID</x-table.cell>
                    <x-table.cell header sortable sortField="event">Event</x-table.cell>
                    <x-table.cell header sortable sortField="auditable_type">Model</x-table.cell>
                    <x-table.cell header sortable sortField="user_name">User</x-table.cell>
                    <x-table.cell header>Changes</x-table.cell>
                    <x-table.cell header sortable sortField="created_at" class="text-center">Date</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($auditLogs as $log)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $log->id }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <x-ui.badge :variant="match ($log->event) {
                                    'created' => 'success',
                                    'updated' => 'info',
                                    'deleted' => 'danger',
                                    'attached', 'synced' => 'warning',
                                    'detached' => 'secondary',
                                    default => 'primary',
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
