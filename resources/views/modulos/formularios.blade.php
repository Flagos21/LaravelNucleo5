@extends('layouts.app')

@section('title', 'M1 — Creación de Formularios')
@section('page-title', 'Módulo 1 — Creación de Formularios')
@section('page-subtitle', 'Qué es un formulario en Laravel, @csrf, old() y método POST')

@section('content')

<div class="grid grid-cols-2 gap-6">

    {{-- ═══════════════════════════════════
         COLUMNA IZQUIERDA — TEORÍA
    ═══════════════════════════════════ --}}
    <div class="space-y-5">

        {{-- Concepto --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-3 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded">TEORÍA</span>
                Formularios en Laravel
            </h2>
            <div class="prose prose-sm text-gray-600 space-y-3 text-sm leading-relaxed">
                <p>Un formulario en Laravel se crea en una vista Blade con la etiqueta HTML
                   <code class="bg-gray-100 px-1 rounded">&lt;form&gt;</code>. El atributo <strong>action</strong>
                   apunta a la ruta que recibirá los datos, y <strong>method</strong> define si se usa GET o POST.</p>

                <p><strong class="text-gray-800">@@csrf</strong> — Blade inserta automáticamente un campo oculto
                   con un token de seguridad. Laravel lo verifica en cada petición POST para prevenir ataques
                   CSRF (Cross-Site Request Forgery).</p>

                <p><strong class="text-gray-800">old()</strong> — Repopula los campos con los valores ingresados
                   anteriormente. Útil para cuando la validación falla y el usuario no tiene que volver a escribir todo.</p>

                <p><strong class="text-gray-800">Flujo básico:</strong><br>
                   Blade → POST → Route → Controller → Model::create() → redirect()</p>
            </div>
        </div>

        {{-- Código: Ruta --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <code class="font-mono">routes/web.php</code> — Rutas del módulo
            </h3>
            <pre><code class="language-php">// Módulo 1 — Creación de formularios
Route::get('/modulo/formularios',
    [ModuloController::class, 'formularios'])
    ->name('modulos.formularios');

Route::post('/modulo/formularios',
    [ModuloController::class, 'guardarFicha'])
    ->name('modulos.formularios.store');</code></pre>
        </div>

        {{-- Código: Controlador --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <code class="font-mono">ModuloController.php</code>
            </h3>
            <pre><code class="language-php">public function formularios()
{
    $fichas = Ficha::latest()->get();
    return view('modulos.formularios',
                compact('fichas'));
}

public function guardarFicha(Request $request)
{
    // Sin validación aún — módulo 1 sólo muestra
    // cómo crear y enviar el formulario
    Ficha::create($request->only([
        'nombre', 'email',
        'carrera', 'mensaje'
    ]));

    return redirect()
        ->route('modulos.formularios')
        ->with('exito', 'Ficha guardada.');
}</code></pre>
        </div>

        {{-- Código: Blade --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <code class="font-mono">formularios.blade.php</code> — fragmento clave
            </h3>
            @verbatim
            <pre><code class="language-php">&lt;form action="{{ route('modulos.formularios.store') }}"
      method="POST"&gt;

    @csrf  {{-- Token de seguridad CSRF --}}

    &lt;input type="text" name="nombre"
           value="{{ old('nombre') }}"&gt;

    &lt;select name="carrera"&gt;
        &lt;option value="Ing. Civil Informática"
            {{ old('carrera') === 'Ing. Civil Informática'
               ? 'selected' : '' }}&gt;
            Ing. Civil Informática
        &lt;/option&gt;
    &lt;/select&gt;

    &lt;button type="submit"&gt;Guardar&lt;/button&gt;
&lt;/form&gt;</code></pre>
            @endverbatim
        </div>

        {{-- Código: Modelo --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                <code class="font-mono">app/Models/Ficha.php</code>
            </h3>
            <pre><code class="language-php">class Ficha extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'email',
        'carrera',
        'mensaje',
    ];
}</code></pre>
        </div>
    </div>

    {{-- ═══════════════════════════════════
         COLUMNA DERECHA — PRÁCTICA
    ═══════════════════════════════════ --}}
    <div class="space-y-5">

        {{-- Formulario --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded">PRÁCTICA</span>
                Ficha de Estudiante
            </h2>

            {{-- Mensaje de éxito --}}
            @if (session('exito'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-4 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('exito') }}
            </div>
            @endif

            <form action="{{ route('modulos.formularios.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre completo</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           placeholder="Ej: Ana García López"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="estudiante@ejemplo.cl"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                {{-- Carrera --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                    <select name="carrera"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        <option value="">-- Selecciona tu carrera --</option>
                        <option value="Ing. Civil Informática"
                            {{ old('carrera') === 'Ing. Civil Informática' ? 'selected' : '' }}>
                            Ing. Civil Informática
                        </option>
                        <option value="Ing. Comercial"
                            {{ old('carrera') === 'Ing. Comercial' ? 'selected' : '' }}>
                            Ing. Comercial
                        </option>
                        <option value="Otro"
                            {{ old('carrera') === 'Otro' ? 'selected' : '' }}>
                            Otro
                        </option>
                    </select>
                </div>

                {{-- Mensaje --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mensaje (opcional)</label>
                    <textarea name="mensaje" rows="3" placeholder="Escribe un mensaje o presentación breve..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none">{{ old('mensaje') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-[#1e3a5f] hover:bg-blue-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Guardar Ficha
                </button>
            </form>
        </div>

        {{-- Tabla de fichas --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center justify-between">
                Fichas registradas
                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $fichas->count() }} total
                </span>
            </h3>

            @if ($fichas->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">Aún no hay fichas registradas.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Nombre</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Email</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Carrera</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Fecha</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($fichas as $ficha)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 font-medium text-gray-800">{{ $ficha->nombre }}</td>
                            <td class="px-3 py-2 text-gray-500">{{ $ficha->email }}</td>
                            <td class="px-3 py-2">
                                <span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded text-xs">{{ $ficha->carrera }}</span>
                            </td>
                            <td class="px-3 py-2 text-gray-400">{{ $ficha->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

    </div>{{-- fin columna derecha --}}
</div>
@endsection
