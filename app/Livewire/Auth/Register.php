<?php

namespace App\Livewire\Auth;

use App\Enums\Course;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $course = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $this->validate([
            'course' => ['required', Rule::enum(Course::class)],
            // ...other rules
        ]);
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'courses' => Course::cases(),
        ]);
    }
}
