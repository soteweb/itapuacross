<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Itapúa Cross' }}</title>

        <!-- Tailwind CSS (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Livewire Styles -->
        @livewireStyles
    </head>
    <body class="bg-gray-50 text-gray-900 min-h-screen font-sans antialiased">
        
        <header class="bg-white shadow-md border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <img src="https://itapuacross.com.py/wp-content/uploads/2024/04/Logo-Crosstime-1.jpg" alt="Logo Itapúa Cross" class="h-10 w-auto mr-3 rounded-md">
                            <h1 class="text-xl md:text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-yellow-500 tracking-tight">
                                ITAPÚA CROSS
                            </h1>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md font-semibold transition-colors">Eventos</a>
                        @foreach(\App\Models\MenuItem::where('placement', 'header')->orderBy('order')->get() as $menu)
                            <a href="{{ str_starts_with($menu->url, 'http') ? $menu->url : url($menu->url) }}" target="{{ $menu->target }}" class="text-gray-600 hover:text-orange-600 px-3 py-2 rounded-md font-semibold transition-colors">{{ $menu->name }}</a>
                        @endforeach
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-orange-600 transition-colors uppercase tracking-wider border-l border-gray-300 pl-8">Admin</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8 min-h-[50vh]">
            {{ $slot }}
        </main>

        <!-- Dynamic Footer -->
        <footer class="bg-gray-900 border-t border-gray-800 mt-12">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between flex-col md:flex-row space-y-6 md:space-y-0">
                    <div class="flex justify-center md:justify-start items-center">
                        <img src="https://itapuacross.com.py/wp-content/uploads/2024/04/Logo-Crosstime-1.jpg" alt="Logo Itapúa Cross" class="h-8 w-auto mr-3 rounded-md grayscale hover:grayscale-0 transition-all duration-300">
                        <h2 class="text-xl font-black text-white tracking-tight">ITAPÚA <span class="text-orange-500">CROSS</span></h2>
                    </div>
                    <div class="flex flex-wrap gap-4 md:gap-8 text-sm justify-center md:justify-start">
                        @forelse(\App\Models\MenuItem::where('placement', 'footer')->orderBy('order')->get() as $menu)
                            <a href="{{ str_starts_with($menu->url, 'http') ? $menu->url : url($menu->url) }}" target="{{ $menu->target }}" class="text-gray-400 hover:text-white transition-colors font-bold uppercase tracking-wider">{{ $menu->name }}</a>
                        @empty
                            <span class="text-gray-500 font-bold uppercase tracking-wider text-xs">Sin enlaces configurados</span>
                        @endforelse
                    </div>
                    <div class="flex justify-center md:justify-end text-sm text-gray-500 font-bold">
                        &copy; {{ date('Y') }} Itapúa Cross. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </footer>

        <!-- Livewire Scripts -->
        @livewireScripts
    </body>
</html>
