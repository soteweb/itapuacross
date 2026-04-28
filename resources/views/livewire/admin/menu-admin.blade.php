<div>
    <x-slot name="title">Gestión de Menús - Itapúa Admin</x-slot>

    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-gray-900 border-l-4 border-orange-500 pl-4 mb-2">Menús Dinámicos</h1>
            <p class="text-gray-500">Administra los enlaces de la barra superior (Header) e inferior (Footer).</p>
        </div>
        <button wire:click="create()" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-xl flex items-center transition-colors shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Nuevo Enlace
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl relative mb-6 shadow-sm" role="alert">
            <span class="block sm:inline font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Menú Principal (Header) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-black text-gray-900">Menú Principal (Header)</h3>
                <span class="bg-white border border-gray-200 text-xs font-bold px-3 py-1 rounded-full text-gray-600 shadow-sm">{{ $headerItems->count() }} Ítems</span>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($headerItems as $item)
                    <li class="px-6 py-4 hover:bg-gray-50 transition-colors flex justify-between items-center group">
                        <div class="flex items-center">
                            <span class="text-gray-400 font-mono text-sm w-8 block">{{ $item->order }}</span>
                            <div class="ml-2">
                                <span class="font-bold text-gray-900">{{ $item->name }}</span>
                                <span class="text-sm text-gray-500 block break-all">{{ $item->url }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 px-2">
                            <button wire:click="edit({{ $item->id }})" 
                                    class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 border border-blue-100 shadow-sm"
                                    title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $item->id }})" 
                                    class="p-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200 border border-red-100 shadow-sm"
                                    title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-8 text-center text-gray-400 text-sm italic font-medium">No hay enlaces configurados en el Header.</li>
                @endforelse
            </ul>
        </div>

        <!-- Menú Inferior (Footer) -->
        <div class="bg-gray-50 rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-black text-gray-700">Menú Inferior (Footer)</h3>
                <span class="bg-white border border-gray-200 text-xs font-bold px-3 py-1 rounded-full text-gray-500 shadow-sm">{{ $footerItems->count() }} Ítems</span>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($footerItems as $item)
                    <li class="px-6 py-4 hover:bg-gray-100 transition-colors flex justify-between items-center group">
                        <div class="flex items-center">
                            <span class="text-gray-400 font-mono text-sm w-8 block">{{ $item->order }}</span>
                            <div class="ml-2">
                                <span class="font-bold text-gray-700">{{ $item->name }}</span>
                                <span class="text-sm text-gray-500 block break-all">{{ $item->url }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 px-2">
                            <button wire:click="edit({{ $item->id }})" 
                                    class="p-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg transition-all duration-200 border border-blue-100 shadow-sm"
                                    title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button wire:click="confirmDelete({{ $item->id }})" 
                                    class="p-1.5 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all duration-200 border border-red-100 shadow-sm"
                                    title="Eliminar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-8 text-center text-gray-400 text-sm italic font-medium">No hay enlaces configurados en el Footer.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <h3 class="text-xl leading-6 font-black text-gray-900" id="modal-title">
                            {{ $itemId ? 'Editar Enlace' : 'Nuevo Enlace' }}
                        </h3>
                        <div class="mt-6 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nombre Público</label>
                                <input type="text" wire:model="name" placeholder="Ej: Contacto" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-lg p-3 bg-gray-50">
                                @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">URL o Slug (Ruta)</label>
                                <input type="text" wire:model="url" placeholder="Ej: /contacto o https://..." class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-lg p-3 bg-gray-50 font-mono text-blue-600">
                                <span class="text-xs text-gray-400 mt-1 block">Puedes usar rutas (p.e. <code>/resultados</code>) o URLs externas (p.e. <code>https://google.com</code>).</span>
                                @error('url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Visibilidad</label>
                                    <select wire:model="placement" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-lg p-3 bg-gray-50">
                                        <option value="header">Menú Principal (Arriba)</option>
                                        <option value="footer">Footer (Abajo)</option>
                                    </select>
                                    @error('placement') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Orden Visual</label>
                                    <input type="number" wire:model="order" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-lg p-3 bg-gray-50">
                                    <span class="text-xs text-gray-400 mt-1 block">El más bajo aparece primero.</span>
                                    @error('order') <span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <div class="flex items-center">
                                    <input id="target_blank" type="checkbox" wire:model="target" value="_blank" @if($target == '_blank') checked @endif 
                                           class="h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded cursor-pointer"
                                           onchange="this.value = this.checked ? '_blank' : '_self'; @this.set('target', this.value)">
                                    <label for="target_blank" class="ml-3 block text-sm font-bold text-gray-900 cursor-pointer">
                                        Abrir en pestaña nueva
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-orange-600 text-base font-bold text-white hover:bg-orange-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar
                        </button>
                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Modal -->
    @if($isDeleteModalOpen)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true" wire:click="closeDeleteModal"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="relative z-10 inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-black text-gray-900" id="modal-title">Eliminar Enlace</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar este enlace? Desaparecerá de tu web instantáneamente.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-2xl">
                    <button type="button" wire:click="destroy" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Sí, Eliminar
                    </button>
                    <button type="button" wire:click="closeDeleteModal" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-bold text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
