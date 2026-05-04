@extends('layouts.app')

@section('title', 'M4 — Form Request Objects')
@section('page-title', 'Módulo 4 — Form Request Objects')
@section('page-subtitle', 'Encapsula la validación en clases dedicadas: authorize(), rules(), messages(), attributes()')

@section('content')

<div class="grid grid-cols-2 gap-6">

    {{-- ═══════════════ TEORÍA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-3 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded">TEORÍA</span>
                ¿Qué es un Form Request?
            </h2>
            <div class="text-sm text-gray-600 space-y-3 leading-relaxed">
                <p>Un <strong>Form Request</strong> es una clase PHP que encapsula toda la lógica de
                   validación de un formulario, separándola del controlador. Esto hace el controlador
                   más limpio y la validación más reutilizable.</p>

                <div class="bg-blue-50 rounded-lg p-3 text-xs">
                    <p class="font-semibold text-blue-700 mb-2">validate() inline vs Form Request</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-gray-500 mb-1 font-medium">❌ validate() en controlador</p>
                            <p class="text-gray-600">El controlador crece con la lógica de validación. Difícil de reusar.</p>
                        </div>
                        <div>
                            <p class="text-gray-500 mb-1 font-medium">✓ Form Request</p>
                            <p class="text-gray-600">Validación en clase propia. Controlador solo recibe datos ya validados.</p>
                        </div>
                    </div>
                </div>

                <p><strong>Comando Artisan para generar:</strong></p>
                <code class="block bg-gray-900 text-green-400 rounded px-3 py-2 text-xs font-mono">
                    php artisan make:request SoporteRequest
                </code>

                <p>El Form Request se inyecta en el método del controlador como tipo-hint. Laravel lo
                   resuelve automáticamente y ejecuta la validación <em>antes</em> de que el método corra.</p>
            </div>
        </div>

        {{-- Código Form Request completo --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">
                <code class="font-mono">app/Http/Requests/SoporteRequest.php</code>
            </h3>
            <pre><code class="language-php">class SoporteRequest extends FormRequest
{
    // Autoriza a todos (app pública)
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación
    public function rules(): array
    {
        return [
            'solicitante'          =>
                'required|string|max:100',
            'email_contacto'       =>
                'required|email',
            'tipo_incidente'       =>
                'required|in:hardware,software,red,otro',
            'descripcion_problema' =>
                'required|string|min:30|max:500',
            'urgencia'             =>
                'required|in:baja,media,alta,critica',
            'equipo_afectado'      =>
                'nullable|string|max:100',
        ];
    }

    // Mensajes de error personalizados
    public function messages(): array
    {
        return [
            'solicitante.required' =>
                'El nombre del solicitante es obligatorio.',
            'email_contacto.email' =>
                'Ingresa un correo electrónico válido.',
            'tipo_incidente.in' =>
                'El tipo de incidente no es válido.',
            'descripcion_problema.min' =>
                'La descripción debe tener al menos 30 caracteres.',
            'urgencia.required' =>
                'Debes seleccionar el nivel de urgencia.',
            // ... más mensajes
        ];
    }

    // Nombres de atributos amigables
    public function attributes(): array
    {
        return [
            'solicitante'     => 'nombre del solicitante',
            'email_contacto'  => 'correo de contacto',
            'tipo_incidente'  => 'tipo de incidente',
            'urgencia'        => 'urgencia',
        ];
    }
}</code></pre>
        </div>

        {{-- Código Controlador --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">
                <code class="font-mono">FormRequestController.php</code>
            </h3>
            <pre><code class="language-php">class FormRequestController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudSoporte::latest()->get();
        return view('modulos.form-request',
                    compact('solicitudes'));
    }

    // SoporteRequest se inyecta automáticamente.
    // La validación ya ocurrió antes de llegar aquí.
    public function store(SoporteRequest $request)
    {
        // $request->validated() retorna sólo los
        // campos que pasaron la validación
        SolicitudSoporte::create($request->validated());

        return redirect()
            ->route('modulos.form-request')
            ->with('exito', 'Solicitud registrada.');
    }
}</code></pre>
        </div>
    </div>

    {{-- ═══════════════ PRÁCTICA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded">PRÁCTICA</span>
                Solicitud de Soporte TI
            </h2>

            @if (session('exito'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-4 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('exito') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4 text-xs">
                <p class="text-red-700 font-semibold mb-1">Corrige los siguientes campos:</p>
                @foreach ($errors->all() as $error)
                <p class="text-red-600 flex items-center gap-1">
                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    {{ $error }}
                </p>
                @endforeach
            </div>
            @endif

            <form action="{{ route('modulos.form-request.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Solicitante --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre del solicitante <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="solicitante" value="{{ old('solicitante') }}"
                           placeholder="Ej: Dra. Patricia Vega"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('solicitante') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('solicitante')
                    <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Email de contacto <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email_contacto" value="{{ old('email_contacto') }}"
                           placeholder="contacto@unach.cl"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('email_contacto') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('email_contacto')
                    <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipo incidente y Urgencia --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de incidente <span class="text-red-500">*</span>
                        </label>
                        <select name="tipo_incidente"
                                class="w-full border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                                       {{ $errors->has('tipo_incidente') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="">-- Tipo --</option>
                            <option value="hardware" {{ old('tipo_incidente') === 'hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="software" {{ old('tipo_incidente') === 'software' ? 'selected' : '' }}>Software</option>
                            <option value="red"      {{ old('tipo_incidente') === 'red'      ? 'selected' : '' }}>Red</option>
                            <option value="otro"     {{ old('tipo_incidente') === 'otro'     ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('tipo_incidente')
                        <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Urgencia <span class="text-red-500">*</span>
                        </label>
                        <select name="urgencia"
                                class="w-full border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                                       {{ $errors->has('urgencia') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                            <option value="">-- Urgencia --</option>
                            <option value="baja"    {{ old('urgencia') === 'baja'    ? 'selected' : '' }}>Baja</option>
                            <option value="media"   {{ old('urgencia') === 'media'   ? 'selected' : '' }}>Media</option>
                            <option value="alta"    {{ old('urgencia') === 'alta'    ? 'selected' : '' }}>Alta</option>
                            <option value="critica" {{ old('urgencia') === 'critica' ? 'selected' : '' }}>Crítica</option>
                        </select>
                        @error('urgencia')
                        <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Descripción del problema <span class="text-red-500">*</span>
                        <span class="text-xs text-gray-400 font-normal">(min:30, max:500)</span>
                    </label>
                    <textarea name="descripcion_problema" rows="3"
                              placeholder="Describe el problema con detalle (mínimo 30 caracteres)..."
                              class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none
                                     {{ $errors->has('descripcion_problema') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('descripcion_problema') }}</textarea>
                    @error('descripcion_problema')
                    <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                    @enderror
                </div>

                {{-- Equipo afectado --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Equipo afectado
                        <span class="text-xs text-gray-400 font-normal">(opcional)</span>
                    </label>
                    <input type="text" name="equipo_afectado" value="{{ old('equipo_afectado') }}"
                           placeholder="Ej: PC escritorio Lab A-12"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('equipo_afectado')
                    <p class="text-red-500 text-xs mt-1">✕ {{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-[#1e3a5f] hover:bg-blue-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Enviar Solicitud de Soporte
                </button>
            </form>
        </div>

        {{-- Lista de solicitudes --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center justify-between">
                Solicitudes registradas
                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $solicitudes->count() }} total
                </span>
            </h3>
            @if ($solicitudes->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">Aún no hay solicitudes registradas.</p>
            @else
            <div class="space-y-2">
                @foreach ($solicitudes as $s)
                @php
                    $urgenciaBadge = match($s->urgencia) {
                        'critica' => 'bg-red-600 text-white',
                        'alta'    => 'bg-red-100 text-red-700',
                        'media'   => 'bg-yellow-100 text-yellow-700',
                        default   => 'bg-green-100 text-green-700',
                    };
                @endphp
                <div class="border border-gray-100 rounded-lg p-3 hover:bg-gray-50 text-xs">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="font-semibold text-gray-800">{{ $s->solicitante }}</div>
                            <div class="text-gray-400">{{ $s->email_contacto }}</div>
                        </div>
                        <span class="{{ $urgenciaBadge }} px-2 py-0.5 rounded text-xs font-semibold capitalize shrink-0">
                            {{ $s->urgencia }}
                        </span>
                    </div>
                    <div class="flex gap-2 mt-2">
                        <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded capitalize">{{ $s->tipo_incidente }}</span>
                        @if ($s->equipo_afectado)
                        <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded">{{ $s->equipo_afectado }}</span>
                        @endif
                    </div>
                    <p class="text-gray-500 mt-2 line-clamp-2">{{ $s->descripcion_problema }}</p>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
