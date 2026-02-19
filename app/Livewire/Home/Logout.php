<?php

namespace App\Livewire\Home;

use App\Services\AuthService;
use Livewire\Component;

class Logout extends Component
{
    public function logout(AuthService $authService): void
    {
        $authService->logout();

        $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.home.logout');
    }
}
