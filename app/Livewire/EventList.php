<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class EventList extends Component
{
    public $showAll = false;

    public function toggleShowAll()
    {
        $this->showAll = true;
    }

    public function render()
    {
        $query = Event::with(['categories', 'eventType'])
            ->where('is_active', true)
            ->where('date', '>=', now()->startOfDay())
            ->orderBy('date', 'asc');

        $totalEvents = (clone $query)->count();

        if (!$this->showAll) {
            $query->limit(6);
        }

        $events = $query->get();

        return view('livewire.event-list', [
            'events' => $events,
            'totalEvents' => $totalEvents
        ])->layout('components.layouts.app', ['title' => 'Itapúa Cross - Eventos Deportivos']);
    }
}
