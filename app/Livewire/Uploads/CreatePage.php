<?php

namespace App\Livewire\Uploads;

use App\Enums\DocumentStatus;
use App\Enums\DocumentVisibility;
use App\Models\Category;
use App\Models\Document;
use App\Models\Tag;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
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

    public array $tags = [];

    public string $tagSearch = '';

    public array $suggestedTags = [];

    public bool $showSuggestions = false;

    public function mount(): void
    {
        $this->authorize('create', Document::class);

        $this->visibility = DocumentVisibility::PUBLIC->value;
        $this->status = DocumentStatus::ACTIVE->value;

        $this->tags = [['name' => '']];

        if (request()->has('category')) {
            $categoryId = (int) request()->get('category');
            if (Category::where('id', $categoryId)->exists()) {
                $this->category_id = $categoryId;
            }
        }
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'visibility' => ['required', Rule::enum(DocumentVisibility::class)],
            'status' => ['required', Rule::enum(DocumentStatus::class)],
            'file' => ['required', 'file', 'mimes:pdf', 'max:102400'],
            'tags.*.name' => ['nullable', 'string', 'max:50'],
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
            'tags.*.name.max' => 'Tag name must not exceed 50 characters.',
        ];
    }

    public function addTag(): void
    {
        $this->tags[] = ['name' => ''];
    }

    public function removeTag(int $index): void
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);

        if (empty($this->tags)) {
            $this->tags = [['name' => '']];
        }
    }

    public function updatedTagSearch(): void
    {
        if (strlen($this->tagSearch) >= 2) {
            $this->suggestedTags = Tag::where('name', 'like', '%'.$this->tagSearch.'%')
                ->orderBy('name')
                ->limit(10)
                ->get()
                ->map(fn ($tag) => [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'document_count' => $tag->document_count ?? 0,
                ])
                ->toArray();

            $this->showSuggestions = ! empty($this->suggestedTags);
        } else {
            $this->suggestedTags = [];
            $this->showSuggestions = false;
        }
    }

    public function selectTag(string $tagName, int $index): void
    {
        $this->tags[$index]['name'] = $tagName;
        $this->tagSearch = '';
        $this->showSuggestions = false;
        $this->suggestedTags = [];
    }

    public function save(): void
    {
        $this->authorize('create', Document::class);

        $validated = $this->validate();

        try {
            $this->validateFileType();

            DB::beginTransaction();

            $document = $this->createDocument($validated);
            $this->attachTags($document);

            DB::commit();

            RedirectNotification::success('Document uploaded successfully!');
            $this->redirect(route('documents.index'), navigate: true);
        } catch (\RuntimeException $e) {
            DB::rollBack();
            $this->dispatchErrorNotification($e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchErrorNotification('An error occurred while uploading the document.');
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

    private function validateFileType(): void
    {
        $extension = $this->file->guessExtension();

        if ($extension !== 'pdf') {
            throw new \RuntimeException('Invalid file type. Only PDF files are allowed.');
        }
    }

    private function createDocument(array $validated): Document
    {
        $uniqueSlug = $this->generateUniqueSlug($validated['title']);
        $filePath = $this->uploadFile($uniqueSlug);

        return Document::create([
            'title' => $validated['title'],
            'slug' => $uniqueSlug,
            'description' => $validated['description'],
            'file_url' => $filePath,
            'uploaded_by' => auth()->id(),
            'category_id' => $validated['category_id'],
            'visibility' => $validated['visibility'],
            'status' => $validated['status'],
            'view_count' => 0,
        ]);
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $timestamp = now()->format('YmdHis');

        return $baseSlug.'-'.$timestamp;
    }

    private function uploadFile(string $uniqueSlug): string
    {
        $extension = $this->file->guessExtension();
        $fileName = $uniqueSlug.'.'.$extension;

        return Storage::disk('public')->putFileAs('documents', $this->file, $fileName);
    }

    private function attachTags(Document $document): void
    {
        $tagIds = $this->processTagsInput();

        if (! empty($tagIds)) {
            $document->tags()->attach($tagIds);
        }
    }

    private function processTagsInput(): array
    {
        $tagIds = [];

        foreach ($this->tags as $tagData) {
            if (empty($tagData['name'])) {
                continue;
            }

            $tagName = trim($tagData['name']);
            $tagSlug = Str::slug($tagName);

            $tag = Tag::firstOrCreate(
                ['slug' => $tagSlug],
                ['name' => $tagName]
            );

            $tagIds[] = $tag->id;
        }

        return array_unique($tagIds);
    }

    private function dispatchErrorNotification(string $message): void
    {
        $this->dispatch('notify', message: $message, type: 'error');
    }
}
