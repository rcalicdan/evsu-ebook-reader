<?php

namespace App\Livewire\Auth;

use App\Services\AuthService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

#[Layout('components.layouts.auth')]
#[Title('Login - EVSU eBook')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public bool $remember = false;

    public function login(AuthService $authService)
    {
        $this->validate();

        try {
            $user = $authService->login($this->email, $this->password, $this->remember);

            session()->regenerate();

            $this->dispatch(
                'notify',
                message: 'Welcome back, ' . $user->name . '!',
                type: 'success'
            );

            $intendedRoute = match (true) {
                $user->isSuperAdmin(), $user->isAdmin() => route('dashboard.index'),
                default => route('dashboard.index'),
            };

            return $this->redirect($intendedRoute, navigate: false);
        } catch (ValidationException $e) {
            $this->dispatch(
                'notify',
                message: 'Invalid credentials. Please try again.',
                type: 'error'
            );

            $this->reset('password');

            throw $e;
        } catch (\Exception $e) {
            $this->dispatch(
                'notify',
                message: 'An error occurred. Please try again.',
                type: 'error'
            );

            $this->reset('password');
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
