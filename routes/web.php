<?php

use App\Livewire\Profile\Settings;
use App\Http\Controllers\DocumentPreviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home\IndexPage::class)->name('home');
Route::get('documents', \App\Livewire\Home\TablePage::class)->name('home.documents');
Route::get('documents/{document}', \App\Livewire\Home\DocumentShowPage::class)->name('home.documents.show');

Route::middleware('guest')->group(function () {
    Route::get('login', \App\Livewire\Auth\Login::class)->name('login');
});

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::post('logout', \App\Livewire\Auth\Logout::class)->name('logout');

    Route::prefix("users")->group(function () {
        Route::get('', \App\Livewire\Users\TablePage::class)->name('users.index');
        Route::get('create', \App\Livewire\Users\CreatePage::class)->name('users.create');
        Route::get('{user}/edit', \App\Livewire\Users\UpdatePage::class)->name('users.edit');
    });

    Route::get('profile', Settings::class)->name('profile');

    Route::prefix("")->group(function () {
        Route::get('', \App\Livewire\Dashboard\IndexPage::class)->name('dashboard.index');
    });

    Route::prefix("categories")->group(function () {
        Route::get('', \App\Livewire\Categories\TablePage::class)->name('categories.index');
        Route::get('create', \App\Livewire\Categories\CreatePage::class)->name('categories.create');
        Route::get('{category}', \App\Livewire\Categories\ShowPage::class)->name('categories.show');
        Route::get('{category}/edit', \App\Livewire\Categories\UpdatePage::class)->name('categories.edit');
    });

    Route::prefix("uploads")->group(function () {
        Route::get('', \App\Livewire\Uploads\CreatePage::class)->name('uploads.index');
    });

    Route::prefix("documents")->group(function () {
        Route::get('', \App\Livewire\Documents\TablePage::class)->name('documents.index');

        Route::get('preview/{document}', [DocumentPreviewController::class, 'index'])
            ->middleware('throttle:60,1')
            ->name('documents.preview');

        Route::get('edit/{document}', \App\Livewire\Documents\UpdatePage::class)->name('documents.edit');

        Route::get('{document}', \App\Livewire\Documents\ShowPage::class)->name('documents.show');
    });

    Route::prefix("audit-logs")->group(function () {
        Route::get('', \App\Livewire\AuditLogs\TablePage::class)->name('audit-logs.index');
        Route::get('{auditLog}', \App\Livewire\AuditLogs\ShowPage::class)->name('audit-logs.show');
    });
});