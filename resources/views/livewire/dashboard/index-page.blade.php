<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-sm text-gray-500">Overview of your document management system</p>
        </div>
        <div class="text-sm text-gray-500">
            Last updated: <span class="font-semibold text-gray-900">{{ now()->format('M d, Y g:i A') }}</span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Documents -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                @if ($documentsGrowth > 0)
                    <span class="text-xs text-green-600 font-medium">+{{ $documentsGrowth }}%</span>
                @elseif($documentsGrowth < 0)
                    <span class="text-xs text-red-600 font-medium">{{ $documentsGrowth }}%</span>
                @else
                    <span class="text-xs text-gray-600 font-medium">0%</span>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalDocuments) }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Documents</p>
        </div>

        <!-- Total Views -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalViews) }}</h3>
            <p class="text-sm text-gray-500 mt-1">Total Views</p>
        </div>

        <!-- Active Categories -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <span class="text-xs text-gray-600 font-medium">All active</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $activeCategories }}</h3>
            <p class="text-sm text-gray-500 mt-1">Active Categories</p>
        </div>

        <!-- New This Month -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ number_format($newThisMonth) }}</h3>
            <p class="text-sm text-gray-500 mt-1">New This Month</p>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Document Status -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Document Status</h3>

            @if ($totalDocuments > 0)
                <div class="space-y-4">
                    <!-- Active -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-gray-700">Active</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($activeCount) }}
                                ({{ $activePercentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $activePercentage }}%"></div>
                        </div>
                    </div>

                    <!-- Archived -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm font-medium text-gray-700">Archived</span>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ number_format($archivedCount) }}
                                ({{ $archivedPercentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full" style="width: {{ $archivedPercentage }}%"></div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">No documents available</p>
                </div>
            @endif
        </div>

        <!-- Top Categories -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Top Categories</h3>

            @if ($topCategories->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($topCategories as $index => $category)
                        @php
                            $colors = ['blue', 'green', 'purple', 'yellow', 'red'];
                            $color = $colors[$index] ?? 'gray';
                            $barWidth =
                                $maxCategoryCount > 0
                                    ? round(($category->documents_count / $maxCategoryCount) * 100, 1)
                                    : 0;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 bg-{{ $color }}-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span
                                    class="text-sm font-bold text-{{ $color }}-600">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                    <span
                                        class="text-sm font-bold text-gray-900">{{ number_format($category->documents_count) }}</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-{{ $color }}-600 h-1.5 rounded-full"
                                        style="width: {{ $barWidth }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 text-sm">No categories available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
            <a href="#" class="text-sm font-medium text-red-600 hover:text-red-700">
                View all
            </a>
        </div>

        <div class="space-y-3">
            <!-- Activity 1 -->
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">
                        <span class="font-semibold">New upload:</span> Research Methodology Guide 2024
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">2 minutes ago</p>
                </div>
            </div>

            <!-- Activity 2 -->
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">
                        <span class="font-semibold">Updated:</span> Course Syllabus - Spring 2024
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">15 minutes ago</p>
                </div>
            </div>

            <!-- Activity 3 -->
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">
                        <span class="font-semibold">Published:</span> Academic Calendar 2024-2025
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">1 hour ago</p>
                </div>
            </div>

            <!-- Activity 4 -->
            <div class="flex items-start gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900">
                        <span class="font-semibold">New upload:</span> Student Handbook 2024
                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">3 hours ago</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-lg p-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-white text-center md:text-left">
                <h3 class="text-xl font-bold mb-1">Ready to add new documents?</h3>
                <p class="text-red-100 text-sm">Upload and manage your documents efficiently</p>
            </div>
            <div class="flex items-center gap-3">
                <a wire:navigate href="{{ route('uploads.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-red-600 font-semibold rounded-lg hover:bg-gray-50 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload Document
                </a>
                <a wire:navigate href="{{ route('documents.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 text-white font-semibold rounded-lg hover:bg-white/20 transition-colors border border-white/30 text-sm">
                    Browse All
                </a>
            </div>
        </div>
    </div>
</div>
