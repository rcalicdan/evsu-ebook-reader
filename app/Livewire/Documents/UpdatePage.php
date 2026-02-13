<?php

namespace App\Livewire\Documents;

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
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

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

    /** @var TemporaryUploadedFile|null */
    public $file;

    public array $tags = [];
    public string $tagSearch = '';
    public array $suggestedTags = [];
    public bool $showSuggestions = false;

    public function mount(Document $document): void
    {
        $this->authorize('update', $document);

        $this->document = $document;
        $this->title = $document->title;
        $this->description = $document->description ?? '';
        $this->category_id = $document->category_id;
        $this->visibility = $document->visibility->value;
        $this->status = $document->status->value;

        $this->loadExistingTags();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'visibility' => ['required', Rule::enum(DocumentVisibility::class)],
            'status' => ['required', Rule::enum(DocumentStatus::class)],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:102400'],
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
            'file.mimes' => 'File must be a PDF.',
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
            $currentTagNames = array_filter(
                array_column($this->tags, 'name'),
                fn($name) => !empty(trim($name))
            );

            $this->suggestedTags = Tag::where('name', 'like', '%' . $this->tagSearch . '%')
                ->whereNotIn('name', $currentTagNames)
                ->orderBy('name')
                ->limit(10)
                ->get()
                ->map(fn($tag) => [
                    'id' => $tag->id,
                    'name' => $tag->name,
                    'slug' => $tag->slug,
                    'document_count' => $tag->document_count ?? 0
                ])
                ->toArray();

            $this->showSuggestions = !empty($this->suggestedTags);
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

    public function update(): void
    {
        $this->authorize('update', $this->document);

        $validated = $this->validate();

        try {
            DB::beginTransaction();

            $this->updateDocumentDetails($validated);

            if ($this->file) {
                $this->replaceDocumentFile();
            }

            $this->syncTags();

            DB::commit();

            RedirectNotification::success('Document updated successfully!');
            $this->redirect(route('documents.index'), navigate: true);
        } catch (\RuntimeException $e) {
            DB::rollBack();
            $this->dispatchErrorNotification($e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatchErrorNotification('An error occurred while updating the document.');
        }
    }

    private function loadExistingTags(): void
    {
        $existingTags = $this->document->tags()
            ->orderBy('name')
            ->get()
            ->map(fn($tag) => ['name' => $tag->name])
            ->toArray();

        $this->tags = !empty($existingTags) ? $existingTags : [['name' => '']];
    }

    private function updateDocumentDetails(array $validated): void
    {
        $this->document->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'visibility' => $validated['visibility'],
            'status' => $validated['status'],
        ]);
    }

    private function replaceDocumentFile(): void
    {
        $this->validateFileType();
        $this->deleteOldFile();

        $filePath = $this->uploadFile();

        $this->document->update(['file_url' => $filePath]);
    }

    private function validateFileType(): void
    {
        $extension = $this->file->guessExtension();

        if ($extension !== 'pdf') {
            throw new \RuntimeException('Invalid file type. Only PDF files are allowed.');
        }
    }

    private function deleteOldFile(): void
    {
        if ($this->document->file_url && Storage::disk('public')->exists($this->document->file_url)) {
            Storage::disk('public')->delete($this->document->file_url);
        }
    }

    private function uploadFile(): string
    {
        $extension = $this->file->guessExtension();
        $fileName = $this->document->slug . '.' . $extension;

        return Storage::disk('public')->putFileAs('documents', $this->file, $fileName);
    }

    private function syncTags(): void
    {
        $tagIds = $this->processTagsInput();

        $this->document->tags()->sync($tagIds);
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
