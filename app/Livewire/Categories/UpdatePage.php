<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class UpdatePage extends Component
{
    use AuthorizesRequests;

    public Category $category;

    public string $name = '';
    public string $description = '';

    public function mount(Category $category): void
    {
        $this->authorize('update', $category);

        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description ?? '';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($this->category->id)],
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

    public function update(): void
    {
        $this->authorize('update', $this->category);

        $validated = $this->validate();

        try {
            $this->category->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'slug' => Str::slug($validated['name'])
            ]);

            RedirectNotification::success('Category updated successfully!');

            $this->redirect(route('categories.index'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while updating the category.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.categories.update-page');
    }
}
