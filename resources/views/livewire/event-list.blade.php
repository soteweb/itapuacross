<div class="space-y-12 pb-12">
    <!-- Hero Carousel Section (AlpineJS) -->
    <div x-data="{
            activeSlide: 0,
            slides: [
                @foreach(App\Models\Event::whereNotNull('featured_image')->where('is_active', true)->take(3)->get() as $e)
                { 
                    image: '{{ Str::startsWith($e->featured_image, "http") ? $e->featured_image : asset("storage/" . $e->featured_image) }}', 
                    subtitle: '{{ Str::limit($e->location_address, 20) }}', 
                    title: '{{ addslashes($e->title) }}' 
                }{{ $loop->last ? '' : ',' }}
                @endforeach
            ]
        }"
        x-init="setInterval(() => activeSlide = (activeSlide === slides.length - 1) ? 0 : activeSlide + 1, 4000)"
        class="relative w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl mt-4 bg-gray-100 border border-gray-200"
    >
        <!-- Alpine Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-105"
                 class="absolute inset-0">
                
                <img :src="slide.image" class="w-full h-full object-contain md:object-cover opacity-90 mix-blend-multiply" :alt="slide.title">
                
                <!-- Gradient Overlay Light -->
                <div class="absolute inset-0 bg-gradient-to-t from-white via-white/80 to-transparent mix-blend-normal"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/50 to-transparent"></div>
                
                <!-- Text Overlay -->
                <div class="absolute bottom-10 left-6 md:left-12 md:bottom-16">
                    <span class="px-4 py-1.5 bg-orange-600 text-white text-xs font-bold uppercase rounded-full shadow-md mb-4 inline-block" x-text="slide.subtitle"></span>
                    <h2 class="text-3xl md:text-6xl font-black text-gray-900 tracking-tighter drop-shadow-sm" x-text="slide.title"></h2>
                    <p class="mt-4 text-sm md:text-lg text-gray-600 max-w-2xl font-medium drop-shadow-sm">
                        Encuentra las mejores competencias deportivas en un solo lugar.
                    </p>
                </div>
            </div>
        </template>

        <!-- Indicators -->
        <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="w-3 h-3 rounded-full transition-all duration-300 shadow-sm border border-gray-300"
                        :class="activeSlide === index ? 'bg-orange-500 w-8 border-orange-500' : 'bg-gray-300 hover:bg-gray-400'">
                </button>
            </template>
        </div>
    </div>

    <!-- Eventos Section -->
    <div>
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-3xl font-black text-gray-900 border-l-4 border-orange-500 pl-4">Próximos Eventos</h3>
            @if(!$showAll && $totalEvents > 6)
            <button wire:click="toggleShowAll" class="text-orange-600 hover:text-orange-700 transition-colors text-sm font-bold uppercase tracking-wider flex items-center">
                Ver Todos 
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $index => $event)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-orange-500/20 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200">
                    
                    <!-- Cover Image / Graphic -->
                    <div class="relative h-48 w-full overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if($event->featured_image)
                            <img src="{{ Str::startsWith($event->featured_image, 'http') ? $event->featured_image : asset('storage/' . $event->featured_image) }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-100 to-gray-200 group-hover:scale-105 transition-transform duration-500"></div>
                        @endif
                        <!-- Abstract category indicator -->
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/diagonal-stripes.png')] mix-blend-overlay"></div>
                        @if($event->eventType)
                            <div class="absolute top-4 left-4 z-10 px-3 py-1 rounded-full text-xs text-white font-bold shadow-md uppercase tracking-wider" style="background-color: {{ $event->eventType->color ?? '#f97316' }}">
                                {{ $event->eventType->name }}
                            </div>
                        @endif
                        <h4 class="z-10 text-gray-800 font-extrabold text-5xl opacity-5 uppercase tracking-tighter">{{ explode(' ', $event->title)[0] }}</h4>
                        
                        <!-- Date Badge -->
                        <div class="absolute bottom-4 left-4 flex items-end space-x-2">
                            <div class="bg-orange-600 text-white px-3 py-2 rounded-xl shadow-lg font-bold text-center leading-none">
                                <span class="block text-2xl">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                <span class="block text-xs uppercase">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('M') }}</span>
                            </div>
                            
                            @php
                                $eventDate = \Carbon\Carbon::parse($event->date)->startOfDay();
                                $now = \Carbon\Carbon::now()->setHour(0)->setMinute(0)->setSecond(0);
                            @endphp

                            <div class="bg-white/90 backdrop-blur-sm text-gray-900 px-3 py-1.5 rounded-lg shadow-sm font-black text-[10px] uppercase tracking-tighter border border-gray-200 mb-1">
                                @if($now->isSameDay($eventDate))
                                    EVENTO HOY
                                @elseif($now->copy()->addDay()->isSameDay($eventDate))
                                    MAÑANA
                                @elseif($now->isBefore($eventDate))
                                    @php
                                        $days = $now->diffInDays($eventDate);
                                        $months = $now->diffInMonths($eventDate);
                                    @endphp
                                    @if($days < 31)
                                        FALTAN {{ (int)$days }} DÍAS
                                    @else
                                        FALTAN {{ (int)$months }} MESES
                                    @endif
                                @else
                                    FINALIZADO
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Content Details -->
                    <div class="p-6 relative">
                        <div class="absolute -top-6 right-6">
                            <span class="bg-white border border-gray-200 text-gray-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md inline-flex items-center">
                                <span class="flex h-2 w-2 relative mr-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                                </span>
                                ABIERTO
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-2 leading-tight group-hover:text-orange-600 transition-colors">
                            <a href="{{ route('event.show', ['id' => $event->id]) }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $event->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $event->description }}
                        </p>

                        <div class="flex flex-col space-y-2 text-sm text-gray-500 mb-6 font-medium">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="truncate">{{ $event->location_address }}</span>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="flex justify-end items-center mt-auto border-t border-gray-100 pt-4">
                            <div class="bg-gray-100 group-hover:bg-orange-600 group-hover:text-white text-gray-600 p-2.5 rounded-full transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(!$showAll && $totalEvents > 6)
            <div class="mt-12 flex justify-center">
                <button wire:click="toggleShowAll" class="bg-white border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-black py-4 px-12 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-orange-500/20 uppercase tracking-widest text-sm">
                    Ver Todos los Eventos ({{ $totalEvents }})
                </button>
            </div>
        @endif

        @if(count($events) == 0)
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-200 shadow-sm mt-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mt-2 text-sm font-bold text-gray-900">No hay eventos activos</h3>
                <p class="mt-1 text-sm text-gray-500">Revisa pronto para conocer nuevas competencias.</p>
            </div>
        @endif
    </div>
</div>
