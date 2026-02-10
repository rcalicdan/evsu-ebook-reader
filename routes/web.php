<?php

use App\Livewire\Dashboard\HomePage;
use App\Livewire\Profile\Settings;
use Illuminate\Support\Facades\Route;

Route::get("/", HomePage::class);

Route::get('/profile', Settings::class)->name('profile');
