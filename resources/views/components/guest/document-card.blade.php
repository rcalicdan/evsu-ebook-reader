@props([
    'title' => 'Document Title Placeholder',
    'category' => 'Uncategorized',
    'status' => 'active',
    'statusColor' => 'green',
])

{{-- The entire card is now a clickable link, a common modern UI pattern --}}
<a href="#" class="group block bg-white border border-slate-200 rounded-xl shadow-sm transition-all duration-300 hover:shadow-lg hover:-translate-y-1.5 overflow-hidden">
    
    <!-- Thumbnail Area -->
    <div class="flex items-center justify-center h-44 bg-slate-50/70 p-4">
        <svg class="w-16 h-16 text-slate-300 transition-colors duration-300 group-hover:text-university-red" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
    </div>

    <!-- Content Area -->
    <div class="p-5">
        {{-- Status and Category are now neatly aligned at the top --}}
        <div class="flex justify-between items-start">
            <p class="text-[11px] font-bold text-university-red uppercase tracking-widest">{{ $category }}</p>
            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800 capitalize">
                {{ $status }}
            </span>
        </div>

        {{-- Title now allows for two lines before truncating, which is more flexible --}}
        <h3 class="mt-2 text-md font-bold text-slate-800 line-clamp-2" title="{{ $title }}">
            {{ $title }}
        </h3>

        {{-- Added placeholder for metadata like publish date for a more complete look --}}
        <p class="mt-4 text-xs text-slate-500 border-t border-slate-100 pt-3">
            Published: 2 days ago
        </p>
    </div>
</a>