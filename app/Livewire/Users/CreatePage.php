<?php

namespace App\Livewire\Users;

use App\Enums\Course;
use App\Enums\UserRole;
use App\Models\User;
use App\Services\RedirectNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class CreatePage extends Component
{
    use AuthorizesRequests;

    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $role = '';
    public string $course = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(): void
    {
        $this->authorize('create', User::class);

        $authUser = auth()->user();

        if ($authUser->isAdmin()) {
            $this->role = UserRole::STUDENT->value;
            // Auto-set course to admin's course
            $this->course = $authUser->course?->value ?? '';
        }
    }

    public function rules(): array
    {
        $allowedRoles = $this->getAllowedRoles();
        $allowedCourses = $this->getAllowedCourses();

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'role'       => ['required', Rule::in(array_keys($allowedRoles))],
            'course'     => ['nullable', Rule::in(array_map(fn($c) => $c->value, $allowedCourses))],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.max'      => 'First name must not exceed 255 characters.',
            'last_name.required'  => 'Last name is required.',
            'last_name.max'       => 'Last name must not exceed 255 characters.',
            'email.required'      => 'Email address is required.',
            'email.email'         => 'Please enter a valid email address.',
            'email.unique'        => 'This email is already taken.',
            'role.required'       => 'System role is required.',
            'role.in'             => 'Please select a valid system role.',
            'course.in'           => 'Please select a valid course.',
            'password.required'   => 'Password is required.',
            'password.min'        => 'Password must be at least 8 characters.',
            'password.confirmed'  => 'Password confirmation does not match.',
        ];
    }

    public function save(): void
    {
        $this->authorize('create', User::class);

        $validated = $this->validate();

        try {
            User::create([
                'first_name'  => $validated['first_name'],
                'last_name'   => $validated['last_name'],
                'email'       => $validated['email'],
                'role'        => $validated['role'],
                'course'      => $validated['course'] ?: null,
                'password'    => Hash::make($validated['password']),
                'is_approved' => true,
            ]);

            RedirectNotification::success('User created successfully!');

            $this->redirect(route('users.index'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while creating the user.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.users.create-page', [
            'roles'          => $this->getAllowedRoles(),
            'courses'        => $this->getAllowedCourses(),
            'courseReadOnly' => auth()->user()->isAdmin(),
        ]);
    }

    private function getAllowedRoles(): array
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $this->getRoles();
        }

        if ($user->isAdmin()) {
            return [
                UserRole::STUDENT->value => UserRole::STUDENT->label(),
            ];
        }

        return [];
    }

    private function getAllowedCourses(): array
    {
        $authUser = auth()->user();

        if ($authUser->isAdmin() && $authUser->course) {
            return [$authUser->course];
        }

        return Course::cases();
    }

    private function getRoles(): array
    {
        return array_reduce(
            UserRole::cases(),
            fn ($carry, $role) => $carry + [$role->value => $role->label()],
            []
        );
    }
}