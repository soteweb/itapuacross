<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\MenuItem;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class MenuAdmin extends Component
{
    public $items;
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    
    public $itemId, $name, $url, $order = 0, $target = '_self', $placement = 'header';

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = MenuItem::orderBy('placement')->orderBy('order', 'asc')->get();
    }

    public function create()
    {
        $this->resetInputFields();
        // pre-fill order to end
        $this->order = MenuItem::where('placement', $this->placement)->max('order') + 1;
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetInputFields()
    {
        $this->itemId = null;
        $this->name = '';
        $this->url = '';
        $this->order = 0;
        $this->target = '_self';
        $this->placement = 'header';
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'required|integer',
            'target' => 'required|in:_self,_blank',
            'placement' => 'required|in:header,footer',
        ]);

        if ($this->itemId) {
            MenuItem::find($this->itemId)->update([
                'name' => $this->name,
                'url' => $this->url,
                'placement' => $this->placement,
                'order' => $this->order,
                'target' => $this->target,
            ]);
            session()->flash('message', 'Enlace actualizado con éxito.');
        } else {
            MenuItem::create([
                'name' => $this->name,
                'url' => $this->url,
                'placement' => $this->placement,
                'order' => $this->order,
                'target' => $this->target,
            ]);
            session()->flash('message', 'Enlace creado con éxito.');
        }

        $this->closeModal();
        $this->loadItems();
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        $this->itemId = $item->id;
        $this->name = $item->name;
        $this->url = $item->url;
        $this->order = $item->order;
        $this->target = $item->target;
        $this->placement = $item->placement;
        $this->openModal();
    }

    public function confirmDelete($id)
    {
        $this->itemId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->itemId = null;
    }

    public function destroy()
    {
        if ($this->itemId) {
            MenuItem::find($this->itemId)->delete();
            session()->flash('message', 'Elemento de menú eliminado.');
        }

        $this->closeDeleteModal();
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.admin.menu-admin', [
            'headerItems' => $this->items->where('placement', 'header'),
            'footerItems' => $this->items->where('placement', 'footer')
        ]);
    }
}
