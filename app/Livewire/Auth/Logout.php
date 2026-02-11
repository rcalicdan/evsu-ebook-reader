<?php

namespace App\Livewire\Auth;

use App\Services\AuthService;
use Livewire\Component;

class Logout extends Component
{
    public function logout(AuthService $authService)
    {
        $authService->logout();

        $this->dispatch('notify', 
            message: 'You have been logged out successfully.',
            type: 'info'
        );

        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}