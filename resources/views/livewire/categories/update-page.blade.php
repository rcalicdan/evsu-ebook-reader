<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Category</h1>
            <p class="text-sm text-gray-500">Update the category details and information.</p>
        </div>
        <x-ui.button variant="secondary" size="sm" href="{{ route('categories.index') }}">
            <x-slot:icon>
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </x-slot:icon>
            Back to Categories
        </x-ui.button>
    </div>

    <!-- Edit Category Card -->
    <form wire:submit.prevent="update">
        <x-form.card>
            <!-- Custom Header with Badge -->
            <x-slot:title>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Category Information</h3>
                        <p class="text-sm text-gray-500 font-normal mt-1">Modify the fields below to update the category.
                        </p>
                    </div>
                    <x-ui.badge variant="info">
                        Active Category
                    </x-ui.badge>
                </div>
            </x-slot:title>

            <x-slot:footer>
                <div class="flex items-center justify-end gap-3">
                    <x-ui.button variant="secondary" href="{{ route('categories.index') }}">
                        Cancel
                    </x-ui.button>

                    <x-ui.button type="submit" variant="primary">
                        <x-slot:icon>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </x-slot:icon>
                        Update Category
                    </x-ui.button>
                </div>
            </x-slot:footer>

            <!-- Category Name -->
            <div>
                <x-form.label for="name" required>Category Name</x-form.label>
                <x-form.input type="text" id="name" wire:model="name" placeholder="e.g. Academic Records"
                    :error="$errors->first('name')">
                    <x-slot:icon>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </x-slot:icon>
                </x-form.input>
            </div>

            <!-- Description Section -->
            <x-form.section title="Category Description" description="Provide additional details about this category">
                <div>
                    <x-form.label for="description">Description</x-form.label>
                    <textarea id="description" wire:model="description" rows="4"
                        placeholder="Provide a brief description of this category..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-university-red/20 focus:border-university-red transition-all @error('description') border-red-500 @enderror"></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Optional: Add a description to help users understand the purpose of this category.</p>
                </div>
            </x-form.section>
        </x-form.card>
    </form>
</div>