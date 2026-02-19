<?php

namespace App\Livewire\Auth;

use App\Enums\Course;
use App\Enums\UserRole;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $course = '';
    public string $student_id = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'first_name'            => ['required', 'string', 'max:100'],
            'last_name'             => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', Rule::unique('users', 'email')],
            'student_id' => [
                'required',
                'string',
                'max:20',
                'regex:/^(19|20)\d{2}-\d{5}$/',
                Rule::unique('student_profiles', 'student_id'),
            ],
            'course'                => ['required', Rule::enum(Course::class)],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'           => 'First name is required.',
            'last_name.required'            => 'Last name is required.',
            'email.required'                => 'Email address is required.',
            'email.email'                   => 'Please enter a valid email address.',
            'email.unique'                  => 'This email is already taken.',
            'student_id.required'           => 'Student ID is required.',
            'student_id.unique'             => 'This Student ID is already registered.',
            'course.required'               => 'Course is required.',
            'course.enum'                   => 'Please select a valid course.',
            'password.required'             => 'Password is required.',
            'password.min'                  => 'Password must be at least 8 characters.',
            'password.confirmed'            => 'Password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        $user = User::create([
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'email'       => $validated['email'],
            'course'      => $validated['course'],
            'password'    => Hash::make($validated['password']),
            'role'        => UserRole::STUDENT,
            'is_approved' => false,
        ]);

        StudentProfile::create([
            'user_id'    => $user->id,
            'student_id' => $validated['student_id'],
        ]);

        Auth::login($user);

        session()->regenerate();

        $this->redirect(route('pending-approval'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'courses' => Course::cases(),
        ]);
    }
}
