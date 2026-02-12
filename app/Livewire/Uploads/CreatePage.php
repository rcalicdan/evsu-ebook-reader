<?php

namespace App\Livewire\Uploads;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use App\Models\Category;
use App\Models\Document;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
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

    /** @var TemporaryUploadedFile|null */
    public $file;

    public function mount(): void
    {
        $this->authorize('create', Document::class);

        $this->visibility = DocumentVisibility::PUBLIC->value;
        $this->status = DocumentStatus::ACTIVE->value;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'visibility' => ['required', Rule::enum(DocumentVisibility::class)],
            'status'     => ['required', Rule::enum(DocumentStatus::class)],
            'file' => ['required', 'file', 'mimes:pdf', 'max:102400'],
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
            'file.mimes' => 'File must be a PDF document.',
            'file.max' => 'File size must not exceed 100MB.',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', Document::class);

        $validated = $this->validate();

        try {
            $extension = $this->file->guessExtension();

            if ($extension !== 'pdf') {
                throw new \RuntimeException('Invalid file type. Only PDF files are allowed.');
            }

            $baseSlug   = Str::slug($validated['title']);
            $timestamp  = now()->format('YmdHis');
            $uniqueSlug = $baseSlug . '-' . $timestamp;
            $fileName   = $uniqueSlug . '.' . $extension;

            $filePath = Storage::disk('public')->putFileAs('documents', $this->file, $fileName);

            Document::create([
                'title'       => $validated['title'],
                'slug'        => $uniqueSlug,
                'description' => $validated['description'],
                'file_url'    => $filePath,
                'uploaded_by' => auth()->id(),
                'category_id' => $validated['category_id'],
                'visibility'  => $validated['visibility'],
                'status'      => $validated['status'],
                'view_count'  => 0,
            ]);

            RedirectNotification::success('Document uploaded successfully!');

            $this->redirect(route('documents.index'), navigate: true);
        } catch (\RuntimeException $e) {
            $this->dispatch(
                'notify',
                message: $e->getMessage(),
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while uploading the document.',
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
