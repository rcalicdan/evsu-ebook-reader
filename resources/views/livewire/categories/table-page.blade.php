<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Category Management</h1>
            <p class="text-sm text-gray-500">Organize and manage document categories for the system.</p>
        </div>
        <div class="flex items-center gap-3">
            @can('create', \App\Models\Category::class)
                <x-ui.button variant="primary" href="{{ route('categories.create') }}">
                    <x-slot:icon>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </x-slot:icon>
                    Add New Category
                </x-ui.button>
            @endcan
        </div>
    </div>

    <!-- Main Table Section -->
    <x-table.index>
        <!-- Search & Filters -->
        <x-table.header>
            <div class="relative w-full md:w-96">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search categories..."
                    class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </x-table.header>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <x-table.head>
                    <x-table.cell header sortable sortField="id">ID</x-table.cell>
                    <x-table.cell header sortable sortField="name">Category Name</x-table.cell>
                    <x-table.cell header class="text-center">Actions</x-table.cell>
                </x-table.head>

                <x-table.body>
                    @forelse($categories as $category)
                        <x-table.row>
                            <x-table.cell>
                                <span class="text-gray-600 font-mono text-sm">{{ $category->id }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <span class="font-bold text-gray-900">{{ $category->name }}</span>
                            </x-table.cell>

                            <x-table.cell>
                                <div class="flex items-center justify-center gap-2">
                                    @can('update', $category)
                                        <x-ui.edit-button :href="route('categories.edit', $category)" />
                                    @endcan

                                    @can('delete', $category)
                                        <x-ui.delete-button :id="$category->id" :name="$category->name" resource="Category"
                                            wire="deleteCategory" />
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
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <p class="text-gray-500 font-medium">No categories found</p>
                                    <p class="text-gray-400 text-sm mt-1">Try adjusting your search or create a new
                                        category</p>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-table.body>
            </table>
        </div>

        <!-- Pagination -->
        <x-ui.pagination :paginator="$categories" />
    </x-table.index>
</div>