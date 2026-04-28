<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Athlete;
use App\Models\Registration;

class RegistrationSearch extends Component
{
    public $search = '';
    public $athlete = null;
    public $registrations = [];
    public $searched = false;

    public function performSearch()
    {
        $this->validate([
            'search' => 'required|min:3',
        ], [
            'search.required' => 'El campo de búsqueda es obligatorio.',
            'search.min' => 'Ingrese al menos 3 caracteres.',
        ]);

        $searchTerm = '%' . $this->search . '%';

        $this->athlete = Athlete::where('identity_document', $this->search)
            ->orWhereRaw("CONCAT(name, ' ', last_name) LIKE ?", [$searchTerm])
            ->orWhere('name', 'LIKE', $searchTerm)
            ->orWhere('last_name', 'LIKE', $searchTerm)
            ->first();
        
        if ($this->athlete) {
            $this->registrations = Registration::where('athlete_id', $this->athlete->id)
                ->with(['event', 'category', 'distance'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $this->registrations = [];
        }

        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.registration-search')
            ->layout('components.layouts.app', ['title' => 'Buscar Estado de Inscripción']);
    }
}
