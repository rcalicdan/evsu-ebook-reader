<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Audit Log Details</h1>
            <p class="text-sm text-gray-500">View detailed information about this audit log entry.</p>
        </div>
        <x-ui.button variant="secondary" :href="route('audit-logs.index')" wire>
            <x-slot:icon>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </x-slot:icon>
            Back to Audit Logs
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Event Information</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                        <dd class="mt-1">
                            <x-ui.badge :variant="match($auditLog->event) {
                                'created' => 'success',
                                'updated' => 'info',
                                'deleted' => 'danger',
                                'attached', 'synced' => 'warning',
                                'detached' => 'secondary',
                                default => 'primary'
                            }" size="lg">
                                {{ $auditLog->formatted_event }}
                            </x-ui.badge>
                        </dd>
                    </div>

                    @if($auditLog->message)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Message</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $auditLog->message }}</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Model</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $auditLog->auditable_type_name }} (ID: {{ $auditLog->auditable_id }})
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-500">Timestamp</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $auditLog->created_at->format('F d, Y \a\t g:i A') }}
                            <span class="text-gray-500">({{ $auditLog->created_at->diffForHumans() }})</span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Changes -->
            @if($auditLog->old_values || $auditLog->new_values)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Changes</h2>
                    <div class="space-y-4">
                        @if($auditLog->event === 'created' && $auditLog->new_values)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">New Values</h3>
                                <div class="bg-green-50 rounded-lg p-4">
                                    <pre class="text-xs text-gray-800 overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @elseif($auditLog->event === 'updated')
                            @if($auditLog->old_values)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Old Values</h3>
                                    <div class="bg-red-50 rounded-lg p-4">
                                        <pre class="text-xs text-gray-800 overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            @endif
                            @if($auditLog->new_values)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">New Values</h3>
                                    <div class="bg-green-50 rounded-lg p-4">
                                        <pre class="text-xs text-gray-800 overflow-x-auto">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            @endif
                        @elseif($auditLog->event === 'deleted' && $auditLog->old_values)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700 mb-2">Deleted Values</h3>
                                <div class="bg-red-50 rounded-lg p-4">
                                    <pre class="text-xs text-gray-800 overflow-x-auto">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Additional Data -->
            @if($auditLog->additional_data)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Additional Data</h2>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <pre class="text-xs text-gray-800 overflow-x-auto">{{ json_encode($auditLog->additional_data, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">User Information</h2>
                @if($auditLog->user)
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-university-red/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-medium text-university-red">
                                    {{ substr($auditLog->user->first_name, 0, 1) }}{{ substr($auditLog->user->last_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $auditLog->user->full_name }}</p>
                                <p class="text-sm text-gray-500">{{ $auditLog->user->email }}</p>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1">
                                <x-ui.badge :variant="$auditLog->user->role->color()">
                                    {{ $auditLog->user->role->label() }}
                                </x-ui.badge>
                            </dd>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">System generated</p>
                @endif
            </div>

            <!-- Request Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Request Information</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $auditLog->ip_address ?? 'N/A' }}</dd>
                    </div>
                    @if($auditLog->url)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                            <dd class="mt-1 text-xs text-gray-900 break-all">{{ $auditLog->url }}</dd>
                        </div>
                    @endif
                    @if($auditLog->user_agent)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">User Agent</dt>
                            <dd class="mt-1 text-xs text-gray-600 break-all">{{ $auditLog->user_agent }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>