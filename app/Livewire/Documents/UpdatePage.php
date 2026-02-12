<?php

namespace App\Livewire\Documents;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use App\Models\Category;
use App\Models\Document;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout("components.layouts.app")]
class UpdatePage extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public Document $document;

    public string $title = '';
    public string $description = '';
    public ?int $category_id = null;
    public string $visibility = '';
    public string $status = '';
    public $file;
    public bool $replaceFile = false;

    public function mount(Document $document): void
    {
        $this->authorize('update', $document);

        $this->document = $document;
        $this->title = $document->title;
        $this->description = $document->description ?? '';
        $this->category_id = $document->category_id;
        $this->visibility = $document->visibility->value;
        $this->status = $document->status->value;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'visibility' => ['required', 'in:' . implode(',', DocumentVisibility::values())],
            'status' => ['required', 'in:' . implode(',', DocumentStatus::values())],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,jpg,jpeg,png', 'max:10240'],
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
            'file.mimes' => 'File must be a PDF, Word, Excel, PowerPoint, text, or image file.',
            'file.max' => 'File size must not exceed 10MB.',
        ];
    }

    public function update(): void
    {
        $this->authorize('update', $this->document);

        $validated = $this->validate();

        try {
            $updateData = [
                'title' => $validated['title'],
                'slug' => Str::slug($validated['title']),
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'visibility' => $validated['visibility'],
                'status' => $validated['status'],
            ];

            // Handle file replacement if a new file is uploaded
            if ($this->file) {
                // Delete old file
                if ($this->document->file_url && Storage::disk('public')->exists($this->document->file_url)) {
                    Storage::disk('public')->delete($this->document->file_url);
                }

                // Store new file
                $filePath = $this->file->store('documents', 'public');
                $updateData['file_url'] = $filePath;
            }

            $this->document->update($updateData);

            RedirectNotification::success('Document updated successfully!');

            $this->redirect(route('documents.index'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while updating the document.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        
        return view('livewire.documents.update-page', [
            'categories' => $categories,
            'visibilityOptions' => DocumentVisibility::cases(),
            'statusOptions' => DocumentStatus::cases(),
        ]);
    }
}