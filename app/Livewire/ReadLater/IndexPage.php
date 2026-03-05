<?php

namespace App\Livewire\ReadLater;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]       
class IndexPage extends Component
{
    public function render()
    {
        return view('livewire.read-later.index-page');
    }
}