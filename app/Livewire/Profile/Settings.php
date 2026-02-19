<?php

namespace App\Livewire\Profile;

use App\Enums\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Settings extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $course;
    public $student_id;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $user = Auth::user();

        $this->first_name = $user->first_name;
        $this->last_name  = $user->last_name;
        $this->email      = $user->email;
        $this->course     = $user->course?->value;

        if ($user->isStudent() && $user->studentProfile) {
            $this->student_id = $user->studentProfile->student_id;
        }
    }

    public function rules(): array
    {
        $user = Auth::user();

        $rules = [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'course'     => ['required', Rule::enum(Course::class)],
        ];

        if ($user->isStudent()) {
            $rules['student_id'] = [
                'required',
                'string',
                'max:20',
                'regex:/^(19|20)\d{2}-\d{5}$/',
                Rule::unique('student_profiles', 'student_id')->ignore($user->studentProfile?->id)
            ];
        }

        if ($this->current_password || $this->new_password || $this->new_password_confirmation) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['new_password']     = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required'               => 'First name is required.',
            'last_name.required'                => 'Last name is required.',
            'email.required'                    => 'Email address is required.',
            'email.email'                       => 'Please enter a valid email address.',
            'email.unique'                      => 'This email is already taken.',
            'course.required'                   => 'Course is required.',
            'course.enum'                       => 'Please select a valid course.',
            'student_id.required'               => 'Student ID is required.',
            'student_id.unique'                 => 'This Student ID is already taken.',
            'current_password.required'         => 'Current password is required to change password.',
            'current_password.current_password' => 'The current password is incorrect.',
            'new_password.required'             => 'New password is required.',
            'new_password.min'                  => 'New password must be at least 8 characters.',
            'new_password.confirmed'            => 'Password confirmation does not match.',
            'student_id.regex' => 'Student ID must follow the format YYYY-NNNNN (e.g. 2021-00001), from 1900 to 2099.',
        ];
    }

    public function updateProfile()
    {
        $validated = $this->validate();

        $user = Auth::user();

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'course'     => $validated['course'],
        ]);

        if ($user->isStudent()) {
            $user->studentProfile()->updateOrCreate(
                ['user_id' => $user->id],
                ['student_id' => $validated['student_id']]
            );
        }

        if ($this->new_password) {
            $user->update(['password' => $this->new_password]);
            $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        }

        $this->dispatch('notify', message: 'Profile updated successfully!', type: 'success');
    }

    public function render()
    {
        return view('livewire.profile.settings', [
            'courses' => Course::cases(),
        ]);
    }
}
