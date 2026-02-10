<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\HomePage;
use App\Livewire\Profile\Settings;
use Illuminate\Support\Facades\Route;

Route::get("/", HomePage::class);

Route::get('/profile', Settings::class)->name('profile');

Route::view("login", "livewire.auth.login")->name("login");
