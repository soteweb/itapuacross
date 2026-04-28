<div>
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-black text-gray-900 border-l-4 border-orange-500 pl-4">Atletas e Inscripciones</h2>
                <p class="text-gray-500 ml-4 font-medium">Gestiona los participantes de todos los eventos.</p>
            </div>
            <div class="flex flex-wrap md:flex-nowrap gap-3">
            <button wire:click="openImportModal" class="px-6 py-3 bg-blue-50 text-blue-700 border border-blue-200 font-bold rounded-xl hover:bg-blue-100 transition-all shadow-sm flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Importar Atletas
            </button>
            <button wire:click="exportToCSV" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Exportar CSV
            </button>
            <button wire:click="openModal" class="px-6 py-3 bg-gray-900 text-white font-black rounded-xl hover:bg-orange-600 transition-all shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Inscripción Manual
            </button>
        </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row gap-4 items-center">
            <div class="flex-1 w-full">
                <input type="text" wire:model.live="search" placeholder="Buscar por nombre, apellido o CI..." class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-orange-500 focus:ring-orange-500 font-medium p-3">
            </div>
            <div class="w-full md:w-64">
                <select wire:model.live="filter_event" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-orange-500 focus:ring-orange-500 font-bold p-3">
                    <option value="">Todos los Eventos</option>
                    @foreach($events as $e)
                        <option value="{{ $e->id }}">{{ $e->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
                <p class="text-sm text-green-700 font-bold">{{ session('message') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Atleta / Contacto</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Documento</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Evento / Distancia</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Categoría</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Detalles</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Pago</th>
                            <th class="p-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($registrations as $reg)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $reg->athlete->name }} {{ $reg->athlete->last_name }}</p>
                                    <p class="text-xs text-gray-500 font-medium">{{ $reg->athlete->phone }} • {{ $reg->athlete->email }}</p>
                                    <p class="text-[10px] text-gray-400">GS: {{ $reg->athlete->blood_type }} • {{ $reg->athlete->club }}</p>
                                </td>
                                <td class="p-4">
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-bold font-mono">{{ $reg->athlete->identity_document }}</span>
                                </td>
                                <td class="p-4">
                                    <p class="text-sm font-bold text-gray-900">{{ $reg->event->title ?? 'N/A' }}</p>
                                    <p class="text-xs text-blue-600 font-bold">{{ $reg->distance->name ?? 'N/A' }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-xs text-orange-600 font-bold uppercase tracking-wide">{{ $reg->category->name ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-gray-500 font-black">Gs {{ number_format($reg->category->price ?? 0, 0, ',', '.') }}</p>
                                </td>
                                <td class="p-4">
                                    <div class="space-y-1">
                                        @if($reg->tshirt_size)
                                            <span class="inline-block bg-purple-50 text-purple-700 text-[10px] font-black px-2 py-0.5 rounded border border-purple-100 uppercase">Talle: {{ $reg->tshirt_size }}</span>
                                        @endif
                                        @if($reg->observation)
                                            <p class="text-[10px] text-gray-500 italic max-w-[150px] truncate" title="{{ $reg->observation }}">{{ $reg->observation }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <button wire:click="togglePaymentStatus({{ $reg->id }})" class="flex flex-col gap-1 w-full text-left group">
                                        @if($reg->payment_status === 'paid')
                                            <span class="bg-green-100 text-green-800 text-[10px] font-black px-2 py-0.5 rounded-full border border-green-200 text-center group-hover:bg-green-200 transition-colors">
                                                Pagado
                                            </span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-[10px] font-black px-2 py-0.5 rounded-full border border-yellow-200 text-center group-hover:bg-yellow-200 transition-colors">
                                                Pendiente
                                            </span>
                                        @endif
                                        <span class="text-[9px] font-bold text-gray-400 uppercase text-center">{{ $reg->payment_method }}</span>
                                    </button>
                                </td>
                                <td class="p-4 text-right">
                                    <button onclick="confirm('¿Estás seguro de eliminar esta inscripción?') || event.stopImmediatePropagation()" wire:click="deleteRegistration({{ $reg->id }})" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-12 text-center">
                                    <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <p class="text-gray-500 font-bold">No hay inscripciones para mostrar.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de Inscripción Manual -->
        @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fadeIn">
            <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh]">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Inscripción Manual</h3>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Registrar atleta en sistema</p>
                    </div>
                    <button wire:click="$set('showModal', false)" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-8 overflow-y-auto space-y-8">
                    <!-- Atleta -->
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] border-b border-orange-100 pb-2">1. Datos del Atleta</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Cédula / Documento</label>
                                <input type="text" wire:model.live.debounce.500ms="identity_document" placeholder="Ingresa CI para autocompletar..." class="w-full rounded-xl border-gray-200 font-bold bg-gray-50 focus:border-orange-500 focus:ring-orange-500 p-3 shadow-inner">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Nombres</label>
                                <input type="text" wire:model="name" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Apellidos</label>
                                <input type="text" wire:model="last_name" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Género</label>
                                <select wire:model="gender" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                                    <option value="">Seleccionar</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Fecha Nac.</label>
                                <input type="date" wire:model="date_of_birth" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                            </div>
                        </div>
                    </div>

                    <!-- Evento -->
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] border-b border-orange-100 pb-2">2. Evento y Categoría</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Evento</label>
                                <select wire:model.live="selected_event_id" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                                    <option value="">-- Seleccionar Evento --</option>
                                    @foreach($events as $e)
                                        <option value="{{ $e->id }}">{{ $e->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Distancia</label>
                                <select wire:model.live="selected_distance_id" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                                    <option value="">-- Distancia --</option>
                                    @foreach($eventDistances as $d)
                                        <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Categoría</label>
                                <select wire:model="selected_category_id" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                                    <option value="">-- Categoría --</option>
                                    @foreach($eventCategories as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }} (Gs. {{ number_format($c->price, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pago -->
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.2em] border-b border-orange-100 pb-2">3. Pago y Extras</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Método Pago</label>
                                <select wire:model="payment_method" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Estado</label>
                                <select wire:model="payment_status" class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3 text-orange-600">
                                    <option value="paid">PAGADO</option>
                                    <option value="pending">PENDIENTE</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase mb-2">Talle Remera</label>
                                <input type="text" wire:model="tshirt_size" placeholder="S, M, L..." class="w-full rounded-xl border-gray-200 font-bold focus:border-orange-500 focus:ring-orange-500 p-3">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-8 border-t border-gray-100 bg-gray-50 flex gap-4">
                    <button wire:click="$set('showModal', false)" class="flex-1 py-4 bg-white border border-gray-200 text-gray-600 font-black rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Cancelar</button>
                    <button wire:click="saveRegistration" class="flex-[2] py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-orange-600 transition-all shadow-xl shadow-orange-100 uppercase tracking-widest text-xs">Confirmar Registro</button>
                </div>
            </div>
        </div>
        @endif

        <!-- Modal de Importación -->
        @if($showImportModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fadeIn">
            <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h3 class="text-xl font-black text-gray-900">Importar Atletas</h3>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-widest mt-1">Carga masiva desde CSV</p>
                    </div>
                    <button wire:click="$set('showImportModal', false)" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="bg-blue-50 border border-blue-100 p-4 rounded-xl">
                        <h4 class="text-xs font-black text-blue-800 uppercase tracking-widest mb-2">Formato Requerido (CSV)</h4>
                        <p class="text-xs text-blue-600 mb-2">El archivo debe tener las siguientes columnas en este orden exacto:</p>
                        <ul class="list-disc list-inside text-xs text-blue-700 font-mono font-bold bg-blue-100/50 p-2 rounded">
                            <li>Cédula</li>
                            <li>Nombres</li>
                            <li>Apellidos</li>
                            <li>Género (M/F)</li>
                            <li>Fecha Nac. (YYYY-MM-DD)</li>
                            <li>Teléfono</li>
                            <li>Email</li>
                        </ul>
                        <div class="mt-4">
                            <button type="button" wire:click="downloadTemplate" class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 text-xs font-black uppercase tracking-widest rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Descargar Plantilla de Ejemplo
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-black text-gray-700">Seleccionar Archivo CSV</label>
                        <input type="file" wire:model="importFile" accept=".csv" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all border border-gray-200 rounded-xl cursor-pointer bg-gray-50">
                        @error('importFile') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    
                    <div wire:loading wire:target="importFile" class="text-xs font-bold text-orange-500">
                        Subiendo archivo...
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-4">
                    <button wire:click="$set('showImportModal', false)" class="flex-1 py-4 bg-white border border-gray-200 text-gray-600 font-black rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">Cancelar</button>
                    <button wire:click="importAthletes" wire:loading.attr="disabled" class="flex-[2] py-4 bg-blue-600 text-white font-black rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-200 uppercase tracking-widest text-xs flex justify-center items-center">
                        <span wire:loading.remove wire:target="importAthletes">Procesar Importación</span>
                        <span wire:loading wire:target="importAthletes" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Importando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
