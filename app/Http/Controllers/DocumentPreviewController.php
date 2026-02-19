<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Log;

class DocumentPreviewController extends Controller
{
    public function index(Document $document)
    {
        $this->authorize('view', $document);

        $filePath = storage_path('app/'.$document->file_url);

        if (! file_exists($filePath)) {
            $filePath = storage_path('app/public/'.$document->file_url);
        }

        if (! file_exists($filePath)) {
            Log::error('Document file not found', [
                'file_url' => $document->file_url,
                'tried_paths' => [
                    storage_path('app/'.$document->file_url),
                    storage_path('app/public/'.$document->file_url),
                ],
            ]);
            abort(404, 'Document file not found');
        }

        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$document->title.'.pdf"',
            'X-Content-Type-Options' => 'nosniff',
            'Content-Security-Policy' => "default-src 'none'; script-src 'none'; object-src 'none'",
            'X-Frame-Options' => 'SAMEORIGIN',
        ]);
    }
}
