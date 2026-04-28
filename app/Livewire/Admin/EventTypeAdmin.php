<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\EventType;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;

#[Layout('components.layouts.admin')]
class EventTypeAdmin extends Component
{
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    
    public $typeId, $name, $slug, $color;

    public function resetInputFields()
    {
        $this->typeId = null;
        $this->name = '';
        $this->slug = '';
        $this->color = '#f97316'; // default orange
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function store()
    {
        \Illuminate\Support\Facades\Log::info('Tentando salvar Tipo de Evento', [
            'name' => $this->name,
            'slug' => $this->slug,
            'color' => $this->color,
            'typeId' => $this->typeId
        ]);

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
        ]);

        $finalSlug = $this->slug ?: \Illuminate\Support\Str::slug($this->name);
        \Illuminate\Support\Facades\Log::info('Slug gerado: ' . $finalSlug);

        // Individual unique check for the final slug
        $existing = EventType::where('slug', $finalSlug)
            ->when($this->typeId, fn($q) => $q->where('id', '!=', $this->typeId))
            ->first();
            
        if ($existing) {
            $this->addError('slug', 'Este identificador ya está en uso (puede que se parezca mucho al nombre de otra categoría).');
            return;
        }

        if ($this->typeId) {
            EventType::find($this->typeId)->update([
                'name' => $this->name,
                'slug' => $finalSlug,
                'color' => $this->color,
            ]);
            session()->flash('message', 'Tipo de evento actualizado con éxito.');
        } else {
            EventType::create([
                'name' => $this->name,
                'slug' => $finalSlug,
                'color' => $this->color,
            ]);
            session()->flash('message', 'Tipo de evento creado con éxito.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $type = EventType::findOrFail($id);
        $this->typeId = $type->id;
        $this->name = $type->name;
        $this->slug = $type->slug;
        $this->color = $type->color;
        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->typeId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->typeId = null;
    }

    public function destroy()
    {
        if ($this->typeId) {
            $type = EventType::find($this->typeId);
            if ($type) {
                // Remove assigned type from events
                \App\Models\Event::where('event_type_id', $type->id)->update(['event_type_id' => null]);
                $type->delete();
                session()->flash('message', 'Tipo de evento eliminado correctamente.');
            }
        }

        $this->closeDeleteModal();
    }

    public function render()
    {
        return view('livewire.admin.event-type-admin', [
            'types' => EventType::orderBy('id', 'desc')->get(),
        ]);
    }
}
