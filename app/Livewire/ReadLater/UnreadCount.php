<?php

namespace App\Livewire\ReadLater;

use App\Models\ReadLater;
use Livewire\Attributes\Computed;
use Livewire\Component;

class UnreadCount extends Component
{
    protected $listeners = [
        'read-later-updated' => '$refresh',
    ];

    #[Computed]
    public function count(): int
    {
        return ReadLater::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
    }

    public function render()
    {
        return view('livewire.read-later.unread-count');
    }
}