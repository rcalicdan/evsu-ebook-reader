<?php

namespace App\Livewire\Users;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class UpdatePage extends Component
{
    use AuthorizesRequests;

    public User $user;

    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $role = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(User $user): void
    {
        $this->authorize('update', $user);

        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role = $user->role->value;
    }

    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'role' => ['required', Rule::in([
                UserRole::STUDENT->value,
                UserRole::ADMIN->value,
                UserRole::SUPERADMIN->value,
            ])],
        ];

        if ($this->password) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.max' => 'First name must not exceed 255 characters.',
            'last_name.required' => 'Last name is required.',
            'last_name.max' => 'Last name must not exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'role.required' => 'System role is required.',
            'role.in' => 'Please select a valid system role.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    public function update(): void
    {
        try {
            $this->authorize('update', $this->user);

            $validated = $this->validate();

            $updateData = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
            ];

            if ($this->password) {
                $updateData['password'] = Hash::make($this->password);
            }

            $this->user->update($updateData);

            $this->reset(['password', 'password_confirmation']);

            $this->dispatch(
                'notify',
                message: 'User updated successfully!',
                type: 'success'
            );

            $this->redirect(route('users.index'), navigate: true);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $this->dispatch(
                'notify',
                message: 'You do not have permission to update this user.',
                type: 'error'
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred while updating the user.',
                type: 'error'
            );
        }
    }

    public function render()
    {
        return view('livewire.users.update-page', [
            'roles' => $this->getRoles(),
        ]);
    }

    private function getRoles(): array
    {
        return array_reduce(
            UserRole::cases(),
            fn($carry, $role) => $carry + [$role->value => $role->label()],
            []
        );
    }
}
