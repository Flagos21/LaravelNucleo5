@extends('layouts.app')

@section('title', 'M3 — Mensajes de Error')
@section('page-title', 'Módulo 3 — Mensajes de Error Personalizados')
@section('page-subtitle', '$errors->any(), @error, old(), mensajes en español junto a cada campo')

@section('content')

<div class="grid grid-cols-2 gap-6">

    {{-- ═══════════════ TEORÍA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-3 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded">TEORÍA</span>
                Mensajes de Error en Blade
            </h2>
            <div class="text-sm text-gray-600 space-y-3 leading-relaxed">
                <p>Laravel pone a disposición la variable <code class="bg-gray-100 px-1 rounded">$errors</code>
                   en todas las vistas Blade. Contiene todos los errores de validación del último request.</p>

                <div class="bg-gray-50 rounded-lg p-3 font-mono text-xs space-y-2">
                    <div><span class="text-purple-600">@</span><span class="text-orange-600">if</span> <span class="text-gray-700">($errors->any())</span>
                        <span class="text-gray-400">// ¿hay algún error?</span></div>
                    <div class="pl-4"><span class="text-purple-600">@</span><span class="text-orange-600">foreach</span>
                        <span class="text-gray-700">($errors->all() as $e)</span></div>
                    <div class="pl-8 text-blue-600">@{{ $e }}</div>
                    <div class="pl-4"><span class="text-purple-600">@</span><span class="text-orange-600">endforeach</span></div>
                    <div><span class="text-purple-600">@</span><span class="text-orange-600">endif</span></div>
                </div>

                <p><strong>@@error('campo')</strong> — Directiva que muestra el mensaje de error
                   específico para un campo. Es la forma más común de mostrar errores junto al input.</p>

                <p><strong>old('campo')</strong> — Recupera el valor que el usuario ingresó antes
                   de que fallara la validación. Evita que el formulario quede en blanco tras el error.</p>

                <p><strong>Mensajes personalizados</strong> — Se pasan como segundo array a
                   <code class="bg-gray-100 px-1 rounded">validate()</code> usando la clave
                   <code class="bg-gray-100 px-1 rounded">campo.regla</code>.</p>
            </div>
        </div>

        {{-- Código @error --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Directiva <code>@@error</code> en Blade</h3>
            @verbatim
            <pre><code class="language-php">{{-- Mostrar error junto al campo --}}
&lt;input type="text" name="nombre_completo"
       value="{{ old('nombre_completo') }}"
       class="{{ $errors->has('nombre_completo')
                ? 'border-red-400 bg-red-50'
                : 'border-gray-300' }}"&gt;

@error('nombre_completo')
    &lt;p class="text-red-500 text-xs mt-1"&gt;
        &#x2716; {{ $message }}
    &lt;/p&gt;
@enderror

{{-- Verificar si hay algún error en el form --}}
@if ($errors->any())
    &lt;div class="bg-red-50 border border-red-300"&gt;
        @foreach ($errors->all() as $error)
            &lt;p&gt;{{ $error }}&lt;/p&gt;
        @endforeach
    &lt;/div&gt;
@endif</code></pre>
            @endverbatim
        </div>

        {{-- Código controlador --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Mensajes personalizados en validate()</h3>
            <pre><code class="language-php">$request->validate(
    [   // Reglas
        'nombre_completo'      =>
            'required|string|min:3|max:80',
        'correo_institucional' =>
            'required|email|ends_with:unach.cl,adventista.cl',
        'asunto'               =>
            'required|string|max:120',
        'prioridad'            =>
            'required|in:baja,media,alta',
        'descripcion'          =>
            'required|string|min:20',
    ],
    [   // Mensajes personalizados en español
        'nombre_completo.required' =>
            'El nombre completo es obligatorio.',
        'nombre_completo.min' =>
            'El nombre debe tener al menos 3 caracteres.',
        'correo_institucional.ends_with' =>
            'El correo debe terminar en @unach.cl o @adventista.cl.',
        'descripcion.min' =>
            'La descripción debe tener al menos 20 caracteres.',
    ]
);</code></pre>
        </div>
    </div>

    {{-- ═══════════════ PRÁCTICA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded">PRÁCTICA</span>
                Contacto Universitario
            </h2>

            @if (session('exito'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-4 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('exito') }}
            </div>
            @endif

            {{-- Panel de errores actuales --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                <h4 class="text-red-700 font-semibold text-sm mb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Log de errores ({{ $errors->count() }} campo(s) con problemas)
                </h4>
                <ul class="space-y-1">
                    @foreach ($errors->messages() as $campo => $msgs)
                    <li class="text-xs">
                        <span class="font-mono bg-red-100 text-red-700 px-1.5 py-0.5 rounded">{{ $campo }}</span>
                        <span class="text-red-600 ml-1">→ {{ $msgs[0] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('modulos.errores.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nombre completo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre completo <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal ml-1">(min:3, max:80)</span>
                    </label>
                    <input type="text" name="nombre_completo" value="{{ old('nombre_completo') }}"
                           placeholder="Ej: Ana García López"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('nombre_completo') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('nombre_completo')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Correo institucional --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Correo institucional <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal ml-1">(debe terminar en @unach.cl o @adventista.cl)</span>
                    </label>
                    <input type="email" name="correo_institucional" value="{{ old('correo_institucional') }}"
                           placeholder="usuario@unach.cl"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('correo_institucional') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('correo_institucional')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Asunto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Asunto <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal ml-1">(max:120)</span>
                    </label>
                    <input type="text" name="asunto" value="{{ old('asunto') }}"
                           placeholder="Ej: Consulta sobre sala de cómputo"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('asunto') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('asunto')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Prioridad --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <select name="prioridad"
                            class="w-full border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                                   {{ $errors->has('prioridad') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        <option value="">-- Selecciona prioridad --</option>
                        <option value="baja"  {{ old('prioridad') === 'baja'  ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ old('prioridad') === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta"  {{ old('prioridad') === 'alta'  ? 'selected' : '' }}>Alta</option>
                    </select>
                    @error('prioridad')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal ml-1">(min:20)</span>
                    </label>
                    <textarea name="descripcion" rows="3"
                              placeholder="Describe tu consulta (mínimo 20 caracteres)..."
                              class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none
                                     {{ $errors->has('descripcion') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-[#1e3a5f] hover:bg-blue-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Enviar Contacto
                </button>
            </form>
        </div>

        {{-- Tabla de contactos --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center justify-between">
                Contactos enviados
                <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $contactos->count() }} total
                </span>
            </h3>
            @if ($contactos->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">Aún no hay contactos registrados.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Nombre</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Asunto</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Prioridad</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($contactos as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2">
                                <div class="font-medium text-gray-800">{{ $c->nombre_completo }}</div>
                                <div class="text-gray-400">{{ $c->correo_institucional }}</div>
                            </td>
                            <td class="px-3 py-2 text-gray-600">{{ Str::limit($c->asunto, 35) }}</td>
                            <td class="px-3 py-2">
                                @php
                                    $badgeColor = match($c->prioridad) {
                                        'alta'  => 'bg-red-100 text-red-700',
                                        'media' => 'bg-yellow-100 text-yellow-700',
                                        default => 'bg-green-100 text-green-700',
                                    };
                                @endphp
                                <span class="{{ $badgeColor }} px-2 py-0.5 rounded capitalize">{{ $c->prioridad }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
