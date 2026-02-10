<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\HomePage;
use App\Livewire\Profile\Settings;
use Illuminate\Support\Facades\Route;

Route::get("/", HomePage::class);

Route::get('/profile', Settings::class)->name('profile');

Route::view("login", "livewire.auth.login")->name("login");

Route::get('/users', \App\Livewire\Users\TablePage::class)->name('users.index');
Route::get('/users/create', \App\Livewire\Users\CreatePage::class)->name('users.create');
Route::get('/users/update', \App\Livewire\Users\UpdatePage::class)->name('users.update');
