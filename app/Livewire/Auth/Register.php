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

    public string $student_id = '';

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'student_id' => ['required', 'string', 'max:20', Rule::unique('student_profiles', 'student_id')],
            'course' => ['required', Rule::enum(Course::class)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    public function register(): void
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'courses' => Course::cases(),
        ]);
    }
}
