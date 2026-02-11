<?php

use App\Livewire\Profile\Settings;
use Illuminate\Support\Facades\Route;

Route::get("/", \App\Livewire\Dashboard\HomePage::class);

Route::get('/profile', Settings::class)->name('profile');

Route::view("login", "livewire.auth.login")->name("login");

Route::prefix("users")->group(function () {
    Route::get('', \App\Livewire\Users\TablePage::class)->name('users.index');
    Route::get('/create', \App\Livewire\Users\CreatePage::class)->name('users.create');
    Route::get('/update', \App\Livewire\Users\UpdatePage::class)->name('users.update');
});

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
