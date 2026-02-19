<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CreatePage extends Component
{
    use AuthorizesRequests;

    public string $name = '';

    public string $description = '';

    public function mount(): void
    {
        $this->authorize('create', Category::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.max' => 'Category name must not exceed 255 characters.',
            'name.unique' => 'This category name already exists.',
            'description.max' => 'Description must not exceed 1000 characters.',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Category::class);

        $validated = $this->validate();

        try {
            Category::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'created_by' => auth()->id(),
                'slug' => Str::slug($validated['name']),
            ]);

            RedirectNotification::success('Category created successfully!');

            $this->redirect(route('categories.index'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while creating the category.'.$e->getMessage(),
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.categories.create-page');
    }
}
