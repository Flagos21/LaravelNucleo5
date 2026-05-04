<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NT5 Laravel') — Formularios y Validaciones</title>

    {{-- TailwindCSS vía CDN (sin compilar) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- highlight.js para resaltado de código --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'azul-unach': '#1e3a5f',
                    }
                }
            }
        }
    </script>

    <style>
        /* Scrollbar del sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }
        /* Bloques de código */
        pre code.hljs { border-radius: 0.5rem; font-size: 0.8rem; }
        /* Transición suave en links */
        .nav-link { transition: background 0.15s, color 0.15s; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex">

    {{-- ───────────── SIDEBAR ───────────── --}}
    <aside class="w-64 min-h-screen bg-white shadow-md flex flex-col fixed top-0 left-0 h-full sidebar-scroll overflow-y-auto z-10">

        {{-- Logo --}}
        <div class="px-6 py-5 border-b border-gray-200">
            <a href="{{ route('dashboard') }}" class="block">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Electivo Profesional I</div>
                <div class="text-lg font-bold text-[#1e3a5f] mt-1">NT5 · Laravel</div>
                <div class="text-xs text-gray-500 mt-0.5">Formularios y Validaciones</div>
            </a>
        </div>

        {{-- Navegación --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Módulos</p>

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('dashboard') ? 'bg-[#1e3a5f] text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f]' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            {{-- M1 Formularios --}}
            <a href="{{ route('modulos.formularios') }}"
               class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('modulos.formularios') ? 'bg-[#1e3a5f] text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f]' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>
                    <span class="block text-xs opacity-70">Módulo 1</span>
                    Creación de Formularios
                </span>
            </a>

            {{-- M2 Validación --}}
            <a href="{{ route('modulos.validacion') }}"
               class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('modulos.validacion') ? 'bg-[#1e3a5f] text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f]' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <span>
                    <span class="block text-xs opacity-70">Módulo 2</span>
                    Validación de Datos
                </span>
            </a>

            {{-- M3 Errores --}}
            <a href="{{ route('modulos.errores') }}"
               class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('modulos.errores') ? 'bg-[#1e3a5f] text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f]' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>
                    <span class="block text-xs opacity-70">Módulo 3</span>
                    Mensajes de Error
                </span>
            </a>

            {{-- M4 Form Request --}}
            <a href="{{ route('modulos.form-request') }}"
               class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('modulos.form-request') ? 'bg-[#1e3a5f] text-white' : 'text-gray-700 hover:bg-blue-50 hover:text-[#1e3a5f]' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <span>
                    <span class="block text-xs opacity-70">Módulo 4</span>
                    Form Request Objects
                </span>
            </a>
        </nav>

        {{-- Footer del sidebar --}}
        <div class="px-5 py-4 border-t border-gray-100 text-xs text-gray-400">
            Universidad Adventista de Chile<br>
            Electivo Profesional I · 2025
        </div>
    </aside>

    {{-- ───────────── CONTENIDO PRINCIPAL ───────────── --}}
    <main class="ml-64 flex-1 min-h-screen">
        {{-- Header de página --}}
        <header class="bg-white border-b border-gray-200 px-8 py-4">
            <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'NT5 — Formularios y Validaciones')</h1>
            <p class="text-sm text-gray-500 mt-0.5">@yield('page-subtitle', 'Desarrollo Web con Laravel · Universidad Adventista de Chile')</p>
        </header>

        {{-- Contenido --}}
        <div class="p-8">
            @yield('content')
        </div>
    </main>

    {{-- Inicializar highlight.js --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('pre code').forEach(el => hljs.highlightElement(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
