<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

#[Layout("components.layouts.app")]
class CreatePage extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';
    
    #[Validate('nullable|string|max:500')]
    public $description = '';
    
    #[Validate('nullable|string|max:255|unique:categories,slug')]
    public $slug = '';
    
    #[Validate('boolean')]
    public $is_active = true;

    public function updatedName()
    {
        // Auto-generate slug from name
        $this->slug = \Illuminate\Support\Str::slug($this->name);
    }

    public function save()
    {
        $validated = $this->validate();
        
        Category::create($validated);
        
        session()->flash('success', 'Category created successfully!');
        
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create-page');
    }
}