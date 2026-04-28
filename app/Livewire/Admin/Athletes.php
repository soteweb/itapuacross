<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Registration;
use App\Models\Athlete;

class Athletes extends Component
{
    use WithFileUploads;

    public $search = '';
    public $filter_event = '';
    
    // Manual Registration Modal
    public $showModal = false;
    
    // Import Modal
    public $showImportModal = false;
    public $importFile;
    public $identity_document = '';
    public $name = '';
    public $last_name = '';
    public $gender = '';
    public $date_of_birth = '';
    public $phone = '';
    public $email = '';
    
    public $selected_event_id = '';
    public $selected_distance_id = '';
    public $selected_category_id = '';
    public $payment_method = 'Efectivo';
    public $payment_status = 'paid';
    public $tshirt_size = '';

    public function togglePaymentStatus($registrationId)
    {
        $reg = Registration::find($registrationId);
        if ($reg) {
            $reg->payment_status = $reg->payment_status === 'pending' ? 'paid' : 'pending';
            $reg->save();
        }
    }

    public function openModal()
    {
        $this->reset(['identity_document', 'name', 'last_name', 'gender', 'date_of_birth', 'phone', 'email', 'selected_event_id', 'selected_distance_id', 'selected_category_id', 'tshirt_size']);
        $this->showModal = true;
    }

    public function updatedIdentityDocument()
    {
        $athlete = \App\Models\Athlete::where('identity_document', $this->identity_document)->first();
        if ($athlete) {
            $this->name = $athlete->name;
            $this->last_name = $athlete->last_name;
            $this->gender = $athlete->gender;
            $this->date_of_birth = $athlete->date_of_birth ? $athlete->date_of_birth->format('Y-m-d') : '';
            $this->phone = $athlete->phone;
            $this->email = $athlete->email;
        }
    }

    public function saveRegistration()
    {
        $this->validate([
            'identity_document' => 'required',
            'name' => 'required',
            'last_name' => 'required',
            'selected_event_id' => 'required',
            'selected_category_id' => 'required',
        ]);

        $athlete = \App\Models\Athlete::updateOrCreate(
            ['identity_document' => $this->identity_document],
            [
                'name' => $this->name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'phone' => $this->phone,
                'email' => $this->email,
            ]
        );

        Registration::create([
            'athlete_id' => $athlete->id,
            'event_id' => $this->selected_event_id,
            'event_distance_id' => $this->selected_distance_id ?: null,
            'event_category_id' => $this->selected_category_id,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'tshirt_size' => $this->tshirt_size,
            'waiver_accepted_at' => now(),
        ]);

        $this->showModal = false;
        session()->flash('message', 'Inscripción manual realizada con éxito.');
    }

    public function deleteRegistration($id)
    {
        Registration::find($id)?->delete();
    }

    public function openImportModal()
    {
        $this->reset('importFile');
        $this->showImportModal = true;
    }

    public function importAthletes()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048', // Max 2MB
        ]);

        $path = $this->importFile->getRealPath();
        $file = fopen($path, 'r');
        
        $header = fgetcsv($file); // Read the header row
        
        // Define expected columns (flexible matching could be added later, but strict for now)
        // Expected: cedula, nombre, apellido, genero, fecha_nacimiento, club, telefono, email, ciudad
        
        $count = 0;
        while (($row = fgetcsv($file)) !== false) {
            // Basic mapping (assuming strict column order for simplicity in this MVP)
            // 0: cedula, 1: nombre, 2: apellido, 3: genero (M/F), 4: fecha_nacimiento (Y-m-d), 5: telefono, 6: email
            
            if (count($row) >= 3) { // At least cedula, nombre, apellido
                $identity = trim($row[0]);
                if (!empty($identity)) {
                    Athlete::updateOrCreate(
                        ['identity_document' => $identity],
                        [
                            'name' => trim($row[1] ?? ''),
                            'last_name' => trim($row[2] ?? ''),
                            'gender' => isset($row[3]) && in_array(strtoupper(trim($row[3])), ['M', 'F']) ? strtoupper(trim($row[3])) : null,
                            'date_of_birth' => !empty(trim($row[4] ?? '')) ? trim($row[4]) : null,
                            'phone' => trim($row[5] ?? ''),
                            'email' => trim($row[6] ?? ''),
                        ]
                    );
                    $count++;
                }
            }
        }
        
        fclose($file);
        
        $this->showImportModal = false;
        session()->flash('message', "Importación completada. Se procesaron/actualizaron $count atletas.");
    }

    public function downloadTemplate()
    {
        $filename = "plantilla_atletas.csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            // Headers
            fputcsv($file, ['Cedula', 'Nombres', 'Apellidos', 'Genero', 'Fecha_Nacimiento', 'Telefono', 'Email']);
            // Example row
            fputcsv($file, ['1234567', 'Juan Carlos', 'Perez', 'M', '1990-05-15', '0981123456', 'juan@ejemplo.com']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportToCSV()
    {
        $query = Registration::with(['athlete', 'event', 'category', 'distance']);

        if ($this->search) {
            $query->whereHas('athlete', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name', 'like', '%'.$this->search.'%')
                  ->orWhere('identity_document', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filter_event) {
            $query->where('event_id', $this->filter_event);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();

        $filename = "inscripciones_" . now()->format('Y-m-d_H-i') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($registrations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'CI', 'Nombre', 'Apellido', 'Evento', 'Distancia', 'Categoria', 'Pago', 'Talle', 'Fecha']);

            foreach ($registrations as $reg) {
                fputcsv($file, [
                    $reg->id,
                    $reg->athlete->identity_document,
                    $reg->athlete->name,
                    $reg->athlete->last_name,
                    $reg->event->title ?? 'N/A',
                    $reg->distance->name ?? 'N/A',
                    $reg->category->name ?? 'N/A',
                    $reg->payment_status,
                    $reg->tshirt_size,
                    $reg->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $query = Registration::with(['athlete', 'event', 'category', 'distance']);

        if ($this->search) {
            $query->whereHas('athlete', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('last_name', 'like', '%'.$this->search.'%')
                  ->orWhere('identity_document', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filter_event) {
            $query->where('event_id', $this->filter_event);
        }

        $registrations = $query->orderBy('created_at', 'desc')->get();
        $events = \App\Models\Event::all();
        
        $selectedEvent = $this->selected_event_id ? \App\Models\Event::with(['distances', 'categories'])->find($this->selected_event_id) : null;

        return view('livewire.admin.athletes', [
            'registrations' => $registrations,
            'events' => $events,
            'eventDistances' => $selectedEvent?->distances ?? collect(),
            'eventCategories' => $selectedEvent?->categories->when($this->selected_distance_id, function($q) {
                return $q->where('event_distance_id', $this->selected_distance_id);
            }) ?? collect(),
        ])->layout('components.layouts.admin', ['title' => 'Atletas / Inscripciones']);
    }
}
