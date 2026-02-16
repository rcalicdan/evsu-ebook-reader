<?php

namespace App\Livewire\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class IndexPage extends Component
{
    public function render()
    {
        return view('livewire.home.index-page');
    }
}
