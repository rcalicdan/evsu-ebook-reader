<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.app")]
class Settings extends Component
{
    public function render()
    {
        return view('livewire.profile.settings');
    }
}
