<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        // Add registration logic later
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}