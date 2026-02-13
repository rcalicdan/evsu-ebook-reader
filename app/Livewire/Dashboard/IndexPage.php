<?php

namespace App\Livewire\Dashboard;

use App\Enums\DocumentStatus;
use App\Models\AuditLog;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class IndexPage extends Component
{
    public function render()
    {
        $data = Cache::flexible('dashboard.stats', [300, 600], fn() => [
            'totalDocuments' => $this->getTotalDocuments(),
            'totalViews' => $this->getTotalViews(),
            'activeCategories' => $this->getActiveCategories(),
            'newThisMonth' => $this->getNewThisMonth(),
            'documentsGrowth' => $this->getDocumentsGrowth(),
            'activeCount' => $this->getActiveCount(),
            'activePercentage' => $this->getActivePercentage(),
            'archivedCount' => $this->getArchivedCount(),
            'archivedPercentage' => $this->getArchivedPercentage(),
            'topCategories' => $this->getTopCategories(),
            'maxCategoryCount' => $this->getMaxCategoryCount(),
        ]);

        $data['recentActivity'] = $this->getRecentActivity();

        return view('livewire.dashboard.index-page', $data);
    }

    private function getRecentActivity()
    {
        return AuditLog::query()
            ->with('user')
            ->latest()
            ->limit(4)
            ->get();
    }

    private function getTotalDocuments(): int
    {
        return Document::count();
    }

    private function getTotalViews(): int
    {
        return Document::sum('view_count');
    }

    private function getActiveCategories(): int
    {
        return Category::count();
    }

    private function getNewThisMonth(): int
    {
        return Document::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
    }

    private function getDocumentsGrowth(): float
    {
        $lastMonthDocuments = Document::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($lastMonthDocuments === 0) {
            return 0;
        }

        return round((($this->getTotalDocuments() - $lastMonthDocuments) / $lastMonthDocuments) * 100, 1);
    }

    private function getStatusBreakdown()
    {
        return Document::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [$item->status->value => $item->count]);
    }

    private function getActiveCount(): int
    {
        return $this->getStatusBreakdown()->get(DocumentStatus::ACTIVE->value, 0);
    }

    private function getArchivedCount(): int
    {
        return $this->getStatusBreakdown()->get(DocumentStatus::ARCHIVED->value, 0);
    }

    private function getActivePercentage(): float
    {
        $totalDocuments = $this->getTotalDocuments();

        if ($totalDocuments === 0) {
            return 0;
        }

        return round(($this->getActiveCount() / $totalDocuments) * 100, 1);
    }

    private function getArchivedPercentage(): float
    {
        $totalDocuments = $this->getTotalDocuments();

        if ($totalDocuments === 0) {
            return 0;
        }

        return round(($this->getArchivedCount() / $totalDocuments) * 100, 1);
    }

    private function getTopCategories()
    {
        return Category::withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->limit(5)
            ->get();
    }

    private function getMaxCategoryCount(): int
    {
        return $this->getTopCategories()->max('documents_count') ?: 1;
    }
}