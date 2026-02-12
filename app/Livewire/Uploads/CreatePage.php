<?php

namespace App\Livewire\Uploads;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use App\Models\Category;
use App\Models\Document;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.app")]
class CreatePage extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public string $title = '';
    public string $description = '';
    public ?int $category_id = null;
    public string $visibility = '';
    public string $status = '';
    public $file;

    public function mount(): void
    {
        $this->authorize('create', Document::class);
        
        // Set default values
        $this->visibility = DocumentVisibility::PUBLIC->value;
        $this->status = DocumentStatus::ACTIVE->value;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'visibility' => ['required', 'in:' . implode(',', DocumentVisibility::values())],
            'status' => ['required', 'in:' . implode(',', DocumentStatus::values())],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png', 'max:10240'], // 10MB max
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Document title is required.',
            'title.max' => 'Document title must not exceed 255 characters.',
            'description.max' => 'Description must not exceed 1000 characters.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category does not exist.',
            'visibility.required' => 'Please select a visibility option.',
            'status.required' => 'Please select a status.',
            'file.required' => 'Please upload a file.',
            'file.mimes' => 'File must be a PDF, Word, Excel, PowerPoint, text, or image file.',
            'file.max' => 'File size must not exceed 10MB.',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Document::class);

        $validated = $this->validate();

        try {
            // Store the file
            $filePath = $this->file->store('documents', 'public');

            Document::create([
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
                'file_url' => $filePath,
                'uploaded_by' => auth()->id(),
                'category_id' => $validated['category_id'],
                'visibility' => $validated['visibility'],
                'status' => $validated['status'],
                'view_count' => 0,
            ]);

            RedirectNotification::success('Document uploaded successfully!');

            $this->redirect(route('documents.index'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while uploading the document. ' . $e->getMessage(),
                type: 'error'
            );
        }
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.uploads.create-page', [
            'categories' => $categories,
            'visibilityOptions' => DocumentVisibility::cases(),
            'statusOptions' => DocumentStatus::cases(),
        ]);
    }
}