<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventShow extends Component
{
    public $event;

    public function mount($id)
    {
        $this->event = Event::with(['categories', 'eventType'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.event-show')
            ->layout('components.layouts.app');
    }
}
