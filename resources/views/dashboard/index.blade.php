@extends('layouts.app')

@section('title', 'Dashboard NT5')
@section('page-title', 'Núcleo Temático 5')
@section('page-subtitle', 'Formularios y Validaciones en Laravel — Vista General')

@section('content')

{{-- Hero --}}
<div class="bg-[#1e3a5f] rounded-xl p-8 text-white mb-8">
    <div class="flex items-start gap-6">
        <div class="bg-white/10 rounded-xl p-4">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold">NT5 — Formularios y Validaciones en Laravel</h2>
            <p class="text-blue-200 mt-2 max-w-2xl">
                Esta aplicación educativa demuestra, de forma interactiva, cómo crear formularios,
                validar datos, personalizar mensajes de error y utilizar Form Request Objects en Laravel.
                Cada módulo muestra el <strong class="text-white">código real del proyecto</strong> junto
                a un <strong class="text-white">formulario funcional</strong> en vivo.
            </p>
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="bg-white/20 text-xs font-semibold px-3 py-1 rounded-full">Laravel 12</span>
                <span class="bg-white/20 text-xs font-semibold px-3 py-1 rounded-full">PHP 8.2</span>
                <span class="bg-white/20 text-xs font-semibold px-3 py-1 rounded-full">MySQL</span>
                <span class="bg-white/20 text-xs font-semibold px-3 py-1 rounded-full">TailwindCSS</span>
            </div>
        </div>
    </div>
</div>

{{-- Contadores --}}
<div class="grid grid-cols-4 gap-4 mb-8">
    @php
        $stats = [
            ['label' => 'Fichas de Estudiantes', 'count' => $contadores['fichas'],              'color' => 'bg-blue-50 border-blue-200 text-blue-700'],
            ['label' => 'Productos Registrados', 'count' => $contadores['productos'],           'color' => 'bg-green-50 border-green-200 text-green-700'],
            ['label' => 'Contactos Enviados',    'count' => $contadores['contactos'],           'color' => 'bg-yellow-50 border-yellow-200 text-yellow-700'],
            ['label' => 'Solicitudes Soporte',   'count' => $contadores['solicitudes_soporte'], 'color' => 'bg-red-50 border-red-200 text-red-700'],
        ];
    @endphp
    @foreach ($stats as $s)
    <div class="bg-white border {{ $s['color'] }} rounded-xl p-5 text-center">
        <div class="text-4xl font-extrabold {{ $s['color'] }}">{{ $s['count'] }}</div>
        <div class="text-sm text-gray-600 mt-1">{{ $s['label'] }}</div>
        <div class="text-xs text-gray-400 mt-0.5">registros en BD</div>
    </div>
    @endforeach
</div>

{{-- Cards de módulos --}}
<h3 class="text-lg font-bold text-gray-700 mb-4">Módulos Disponibles</h3>
<div class="grid grid-cols-2 gap-6 mb-10">

    {{-- M1 --}}
    <a href="{{ route('modulos.formularios') }}" class="group bg-white rounded-xl border border-gray-200 p-6 hover:border-blue-400 hover:shadow-md transition-all">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                <span class="text-blue-600 font-bold text-sm group-hover:text-white">M1</span>
            </div>
            <div>
                <div class="text-xs text-gray-400">Módulo 1</div>
                <div class="font-semibold text-gray-800">Creación de Formularios</div>
            </div>
        </div>
        <p class="text-sm text-gray-500">Aprende a crear formularios en Blade con <code class="bg-gray-100 px-1 rounded">@@csrf</code>,
           método POST, directiva <code class="bg-gray-100 px-1 rounded">old()</code> y cómo guardar datos en la base de datos.</p>
        <div class="mt-4 text-xs font-semibold text-blue-600 group-hover:underline">Ver módulo →</div>
    </a>

    {{-- M2 --}}
    <a href="{{ route('modulos.validacion') }}" class="group bg-white rounded-xl border border-gray-200 p-6 hover:border-green-400 hover:shadow-md transition-all">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-600 transition-colors">
                <span class="text-green-600 font-bold text-sm group-hover:text-white">M2</span>
            </div>
            <div>
                <div class="text-xs text-gray-400">Módulo 2</div>
                <div class="font-semibold text-gray-800">Validación de Datos</div>
            </div>
        </div>
        <p class="text-sm text-gray-500">Domina el método <code class="bg-gray-100 px-1 rounded">validate()</code>,
           las reglas más usadas en formato pipe y array, y cómo aplicarlas a formularios reales.</p>
        <div class="mt-4 text-xs font-semibold text-green-600 group-hover:underline">Ver módulo →</div>
    </a>

    {{-- M3 --}}
    <a href="{{ route('modulos.errores') }}" class="group bg-white rounded-xl border border-gray-200 p-6 hover:border-yellow-400 hover:shadow-md transition-all">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-500 transition-colors">
                <span class="text-yellow-600 font-bold text-sm group-hover:text-white">M3</span>
            </div>
            <div>
                <div class="text-xs text-gray-400">Módulo 3</div>
                <div class="font-semibold text-gray-800">Mensajes de Error</div>
            </div>
        </div>
        <p class="text-sm text-gray-500">Personaliza mensajes de error en español con <code class="bg-gray-100 px-1 rounded">@@error</code>,
           <code class="bg-gray-100 px-1 rounded">$errors->any()</code> y cómo mostrarlos junto a cada campo.</p>
        <div class="mt-4 text-xs font-semibold text-yellow-600 group-hover:underline">Ver módulo →</div>
    </a>

    {{-- M4 --}}
    <a href="{{ route('modulos.form-request') }}" class="group bg-white rounded-xl border border-gray-200 p-6 hover:border-purple-400 hover:shadow-md transition-all">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                <span class="text-purple-600 font-bold text-sm group-hover:text-white">M4</span>
            </div>
            <div>
                <div class="text-xs text-gray-400">Módulo 4</div>
                <div class="font-semibold text-gray-800">Form Request Objects</div>
            </div>
        </div>
        <p class="text-sm text-gray-500">Encapsula la lógica de validación en clases dedicadas con
           <code class="bg-gray-100 px-1 rounded">authorize()</code>, <code class="bg-gray-100 px-1 rounded">rules()</code>
           y <code class="bg-gray-100 px-1 rounded">messages()</code>.</p>
        <div class="mt-4 text-xs font-semibold text-purple-600 group-hover:underline">Ver módulo →</div>
    </a>
</div>

{{-- Mapa de flujo SVG --}}
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h3 class="text-base font-bold text-gray-700 mb-5">Flujo Completo de un Formulario en Laravel</h3>
    <div class="overflow-x-auto">
        <svg viewBox="0 0 900 130" class="w-full max-w-4xl mx-auto" xmlns="http://www.w3.org/2000/svg" font-family="system-ui, sans-serif">
            <!-- Nodos -->
            @php
                $nodes = [
                    [50,  65, 'Usuario',    '#dbeafe', '#1e40af'],
                    [200, 65, 'Blade View', '#dcfce7', '#166534'],
                    [350, 65, 'Route',      '#fef9c3', '#854d0e'],
                    [500, 65, 'Controller', '#ede9fe', '#5b21b6'],
                    [650, 65, 'Validate',   '#fee2e2', '#991b1b'],
                    [800, 65, 'Base Datos', '#f0fdf4', '#15803d'],
                ];
            @endphp
            @foreach ($nodes as $n)
            <rect x="{{ $n[0] - 55 }}" y="{{ $n[1] - 22 }}" width="110" height="44" rx="8"
                  fill="{{ $n[3] }}" stroke="{{ $n[4] }}" stroke-width="1.5"/>
            <text x="{{ $n[0] }}" y="{{ $n[1] + 5 }}" text-anchor="middle"
                  fill="{{ $n[4] }}" font-size="12" font-weight="600">{{ $n[2] }}</text>
            @endforeach

            <!-- Flechas -->
            @for ($i = 0; $i < count($nodes) - 1; $i++)
            <line x1="{{ $nodes[$i][0] + 55 }}" y1="{{ $nodes[$i][1] }}"
                  x2="{{ $nodes[$i+1][0] - 55 }}" y2="{{ $nodes[$i+1][1] }}"
                  stroke="#94a3b8" stroke-width="1.5" marker-end="url(#arr)"/>
            @endfor

            <!-- Etiquetas de flechas -->
            <text x="150" y="52" text-anchor="middle" fill="#64748b" font-size="9">POST / GET</text>
            <text x="275" y="52" text-anchor="middle" fill="#64748b" font-size="9">web.php</text>
            <text x="425" y="52" text-anchor="middle" fill="#64748b" font-size="9">action()</text>
            <text x="575" y="52" text-anchor="middle" fill="#64748b" font-size="9">validate()</text>
            <text x="725" y="52" text-anchor="middle" fill="#64748b" font-size="9">Model::create()</text>

            <!-- Flecha de retorno (redirect) -->
            <path d="M 855 85 Q 455 130 100 85" fill="none" stroke="#94a3b8"
                  stroke-width="1.5" stroke-dasharray="5,3" marker-end="url(#arr)"/>
            <text x="455" y="125" text-anchor="middle" fill="#64748b" font-size="9">redirect() → with('exito')</text>

            <!-- Definición de punta de flecha -->
            <defs>
                <marker id="arr" markerWidth="8" markerHeight="8" refX="6" refY="3" orient="auto">
                    <path d="M0,0 L0,6 L8,3 z" fill="#94a3b8"/>
                </marker>
            </defs>
        </svg>
    </div>
</div>

@endsection
