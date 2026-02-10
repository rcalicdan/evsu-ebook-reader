<?php

namespace App\Livewire\Users;

use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout("components.layouts.app")]
class CreatePage extends Component
{
    public function render()
    {
        return view('livewire.users.create-page');
    }
}
