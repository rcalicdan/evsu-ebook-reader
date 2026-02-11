<?php

use App\Livewire\Profile\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', \App\Livewire\Auth\Logout::class)->name('logout');

    Route::prefix("users")->group(function () {
        Route::get('', \App\Livewire\Users\TablePage::class)->name('users.index');
        Route::get('/create', \App\Livewire\Users\CreatePage::class)->name('users.create');
        Route::get('/users/{user}/edit', \App\Livewire\Users\UpdatePage::class)->name('users.edit');
    });

    Route::get('/profile', Settings::class)->name('profile');

    Route::prefix("/")->group(function () {
        Route::get('', \App\Livewire\Dashboard\HomePage::class)->name('dashboard.index');
    });

    Route::prefix("categories")->group(function () {
        Route::get('', \App\Livewire\Dashboard\HomePage::class)->name('categories.index');
    });

    Route::prefix("uploads")->group(function () {
        Route::get('', \App\Livewire\Dashboard\HomePage::class)->name('uploads.index');
    });

    Route::prefix("documents")->group(function () {
        Route::get('', \App\Livewire\Dashboard\HomePage::class)->name('documents.index');
    });
});
