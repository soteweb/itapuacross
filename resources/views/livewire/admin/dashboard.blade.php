<div>
    <div class="mb-8">
        <h3 class="text-3xl font-black text-gray-900 border-l-4 border-orange-500 pl-4">Resumen del Sistema</h3>
        <p class="text-gray-500 mt-2 font-medium">Estadísticas en tiempo real de la plataforma Itapúa Cross.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Eventos Activos -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Eventos Activos</p>
                <h4 class="text-3xl font-black text-gray-900 mt-1">{{ $metrics['events_active'] }} <span class="text-sm font-medium text-gray-400">/ {{ $metrics['events_total'] }}</span></h4>
            </div>
            <div class="bg-orange-50 p-3 rounded-xl text-orange-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Atletas -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Atletas</p>
                <h4 class="text-3xl font-black text-gray-900 mt-1">{{ $metrics['athletes'] }}</h4>
            </div>
            <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <!-- Registros Totales -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Inscripciones</p>
                <h4 class="text-3xl font-black text-gray-900 mt-1">{{ $metrics['registrations'] }}</h4>
            </div>
            <div class="bg-green-50 p-3 rounded-xl text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
        </div>

        <!-- Ingresos por Cobrar -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase tracking-wide">Por Cobrar (Gs)</p>
                <h4 class="text-2xl font-black text-orange-600 mt-1">{{ number_format($metrics['revenue_pending'], 0, ',', '.') }}</h4>
            </div>
            <div class="bg-yellow-50 p-3 rounded-xl text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
            <h4 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Acciones Rápidas</h4>
            <div class="space-y-3">
                <a href="{{ route('admin.events') }}" class="block p-4 border border-gray-200 rounded-xl hover:border-orange-500 hover:bg-orange-50 transition-all font-bold text-gray-700 flex justify-between items-center group">
                    Crear un nuevo Evento
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                <a href="{{ route('admin.athletes') }}" class="block p-4 border border-gray-200 rounded-xl hover:border-orange-500 hover:bg-orange-50 transition-all font-bold text-gray-700 flex justify-between items-center group">
                    Ver base de datos de Atletas
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
            <h4 class="text-xl font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Sistema</h4>
            <p class="text-gray-600 text-sm font-medium">El panel se encuentra sincronizado. Las inscripciones web están ingresando en vivo con estado <b>Pendiente</b> de pago en la base de datos hasta que decida gestionarlos administrativamente.</p>
        </div>
    </div>
</div>
