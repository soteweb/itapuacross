<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'Admin - Itapúa Cross' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-gray-100 text-gray-900 min-h-screen font-sans antialiased flex">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex shadow-sm sticky top-0 h-screen">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <h1 class="text-xl font-black bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-yellow-500 tracking-tight">
                    ITAPÚA <span class="text-gray-800">ADMIN</span>
                </h1>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.events') }}" class="{{ request()->routeIs('admin.events') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.events') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Gestión de Eventos
                </a>

                <a href="{{ route('admin.event-types') }}" class="{{ request()->routeIs('admin.event-types') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.event-types') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Tipos de Evento
                </a>

                <a href="{{ route('admin.pages') }}" class="{{ request()->routeIs('admin.pages') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.pages') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Páginas (CMS)
                </a>

                <a href="{{ route('admin.menus') }}" class="{{ request()->routeIs('admin.menus') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.menus') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    Menús (Navegación)
                </a>

                <a href="{{ route('admin.athletes') }}" class="{{ request()->routeIs('admin.athletes') ? 'bg-orange-50 text-orange-600' : 'text-gray-600 hover:bg-gray-50' }} flex items-center px-4 py-3 text-sm font-bold rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.athletes') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Atletas / Usuarios
                </a>
            </nav>
            
            <div class="px-6 py-4 border-t border-gray-200">
                <a href="{{ route('home') }}" class="flex items-center text-sm font-bold text-gray-500 hover:text-orange-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Volver al Frontend
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex flex-shrink-0 items-center justify-between px-6 shadow-sm sticky top-0 z-10">
                <div class="flex items-center">
                    <h2 class="text-xl font-black text-gray-800">{{ $title ?? 'Panel' }}</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center text-xs font-black text-orange-600 bg-orange-50 hover:bg-orange-100 border border-orange-200 px-4 py-2 rounded-xl transition-all shadow-sm group">
                        <svg class="w-4 h-4 mr-2 text-orange-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Ver Sitio Web
                    </a>
                    <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full border border-gray-200 shadow-sm">Administrador Activo</span>
                </div>
            </header>
            
            <!-- Dynamic Sub-Content Area -->
            <div class="flex-1 overflow-auto p-6 md:p-8">
                <div class="mx-auto max-w-6xl">
                    {{ $slot }}
                </div>
            </div>
        </main>

        @livewireScripts
    </body>
</html>
