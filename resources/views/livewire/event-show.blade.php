<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Hero Section -->
    <div class="relative h-[400px] md:h-[500px] w-full overflow-hidden bg-gray-900">
        @if($event->featured_image)
            <img src="{{ asset('storage/' . $event->featured_image) }}" class="w-full h-full object-cover opacity-60 scale-105" alt="{{ $event->title }}">
        @else
            <div class="w-full h-full bg-gradient-to-br from-orange-600 to-yellow-500 opacity-40"></div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12">
            <div class="max-w-6xl mx-auto">
                @if($event->eventType)
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-widest text-white mb-4 shadow-lg border border-white/20" style="background-color: {{ $event->eventType->color ?? '#f97316' }}">
                        {{ $event->eventType->name }}
                    </span>
                @endif
                <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4 drop-shadow-2xl">
                    {{ $event->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-6 text-white text-sm md:text-lg font-bold">
                    <div class="flex items-center drop-shadow-md">
                        <svg class="w-6 h-6 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ \Carbon\Carbon::parse($event->date)->isoFormat('dddd D [de] MMMM, Y') }}
                    </div>
                    <div class="flex items-center drop-shadow-md">
                        <svg class="w-6 h-6 mr-2 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->location_address }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="max-w-6xl mx-auto px-6 -mt-10 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Description and Categories -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white p-8 rounded-3xl shadow-xl border border-gray-100 ring-1 ring-gray-900/5">
                    <h2 class="text-2xl font-black text-gray-900 mb-6 flex items-center">
                        <span class="w-1.5 h-8 bg-orange-500 rounded-full mr-3 text-sm"></span>
                        Sobre el Evento
                    </h2>
                    <div class="prose prose-orange max-w-none text-gray-600 leading-relaxed font-medium">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

            </div>

            <!-- Right: Action Sidebar -->
            <div class="space-y-6">
                <!-- Registration Card -->
                <div class="bg-white p-6 rounded-3xl shadow-2xl border border-orange-100 ring-4 ring-orange-50 shadow-orange-200/50">
                    <h3 class="text-xl font-black text-gray-900 mb-6 text-center">Inscripciones Abiertas</h3>
                    
                    @if($event->registration_type === 'external')
                        <a href="{{ $event->external_registration_url }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-black py-4 px-6 rounded-2xl transition-all shadow-lg hover:shadow-blue-200 hover:-translate-y-1 mb-4 flex items-center justify-center">
                            <span class="mr-2">SITIO EXTERNO</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                        <p class="text-[10px] text-gray-400 font-bold text-center uppercase tracking-widest">Serás redirigido a otra plataforma</p>
                    @else
                       <a href="{{ route('events.register', ['event' => $event->id]) }}" class="flex items-center justify-center gap-2 w-full bg-orange-600 hover:bg-orange-700 text-white text-center font-bold text-sm uppercase tracking-wide py-4 px-6 rounded-2xl transition-all shadow-md hover:shadow-orange-200 hover:-translate-y-0.5 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span>Inscribirme ahora</span>
                            </a>
                            <p class="text-[10px] text-gray-400 font-bold text-center uppercase tracking-widest mb-4">Pago seguro vía Itapúa Cross</p>

                            <a href="{{ route('registration.search') }}" class="flex items-center justify-center gap-2 w-full bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-orange-600 text-center font-bold text-xs uppercase tracking-wide py-3 px-6 rounded-2xl transition-all border border-gray-200 hover:border-orange-200">
                                <span>Ver mi estado de inscripción</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </a>
                    @endif

                    <hr class="my-6 border-gray-100">

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-orange-50 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-xs font-black text-gray-400 uppercase">Cierre de Inscripción</span>
                                <span class="text-sm font-bold text-gray-700">Pronto</span>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-orange-50 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <span class="block text-xs font-black text-gray-400 uppercase">¿Cómo llegar?</span>
                                @if($event->google_maps_url)
                                    <a href="{{ $event->google_maps_url }}" target="_blank" class="text-sm font-black text-orange-600 hover:underline flex items-center">
                                        Ver en Google Maps
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @else
                                    <span class="text-sm font-bold text-gray-700">{{ $event->location_address }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Card -->
                <div class="bg-gray-900 p-6 rounded-3xl shadow-xl text-white">
                    <h4 class="text-sm font-black uppercase tracking-widest mb-4">Compartir Evento</h4>
                    <div class="grid grid-cols-3 gap-2">
                        <button class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-colors flex justify-center items-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </button>
                        <button class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-colors flex justify-center items-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </button>
                        <button class="bg-white/10 hover:bg-white/20 p-3 rounded-xl transition-colors flex justify-center items-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
