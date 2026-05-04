@extends('layouts.app')

@section('title', 'M2 — Validación de Datos')
@section('page-title', 'Módulo 2 — Validación de Datos')
@section('page-subtitle', 'validate(), reglas en formato pipe y array, panel de reglas en tiempo real')

@section('content')

<div class="grid grid-cols-2 gap-6">

    {{-- ═══════════════ TEORÍA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-3 flex items-center gap-2">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded">TEORÍA</span>
                Validación con validate()
            </h2>
            <div class="text-sm text-gray-600 space-y-3 leading-relaxed">
                <p>El método <code class="bg-gray-100 px-1 rounded">$request->validate()</code> recibe un array de reglas.
                   Si alguna falla, Laravel redirige automáticamente con los errores en la variable
                   <code class="bg-gray-100 px-1 rounded">$errors</code> y con los valores anteriores en
                   <code class="bg-gray-100 px-1 rounded">old()</code>.</p>

                <p><strong>Formato pipe:</strong> reglas separadas por el carácter <code class="bg-gray-100 px-1 rounded">|</code><br>
                   <code class="bg-gray-100 px-1 rounded text-xs">'nombre' => 'required|string|max:100'</code></p>

                <p><strong>Formato array:</strong> cada regla como elemento del array<br>
                   <code class="bg-gray-100 px-1 rounded text-xs">'precio' => ['required', 'numeric', 'min:0']</code></p>

                <p>Ambos formatos son equivalentes. El array es preferible cuando las reglas son complejas o dinámicas.</p>
            </div>
        </div>

        {{-- Reglas más usadas --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Reglas más usadas</h3>
            <div class="grid grid-cols-2 gap-2 text-xs">
                @php
                    $reglas = [
                        ['required',       'Campo obligatorio'],
                        ['string',         'Debe ser texto'],
                        ['numeric',        'Debe ser número'],
                        ['integer',        'Número entero'],
                        ['email',          'Email válido'],
                        ['min:N',          'Mínimo N (chars/valor)'],
                        ['max:N',          'Máximo N (chars/valor)'],
                        ['in:a,b,c',       'Uno de los valores'],
                        ['nullable',       'Puede ser nulo'],
                        ['unique:tabla',   'Único en BD'],
                        ['confirmed',      'Confirmar campo'],
                        ['date',           'Fecha válida'],
                        ['boolean',        'true / false'],
                        ['url',            'URL válida'],
                        ['regex:/patrón/', 'Expresión regular'],
                        ['ends_with:x,y',  'Termina con x o y'],
                    ];
                @endphp
                @foreach ($reglas as $r)
                <div class="bg-gray-50 rounded px-2 py-1.5">
                    <code class="text-blue-700 font-semibold">{{ $r[0] }}</code>
                    <div class="text-gray-500 mt-0.5">{{ $r[1] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Código del controlador --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3">
                <code class="font-mono">ModuloController@guardarProducto</code>
            </h3>
            <pre><code class="language-php">public function guardarProducto(Request $request)
{
    // validate() detiene la ejecución si falla
    // y redirige con los errores automáticamente
    $request->validate(
        [
            'nombre_producto' =>
                'required|string|max:100',
            'precio'          =>
                'required|numeric|min:0',
            'stock'           =>
                'required|integer|min:0',
            'categoria'       =>
                'required|in:electronico,ropa,alimento,otro',
            'descripcion'     =>
                'nullable|string|max:255',
        ],
        [
            // Segundo array: mensajes personalizados
            'nombre_producto.required' =>
                'El nombre del producto es obligatorio.',
            'precio.numeric' =>
                'El precio debe ser un número.',
            'stock.integer' =>
                'El stock debe ser entero.',
            'categoria.in' =>
                'Categoría no válida.',
        ]
    );

    Producto::create($request->only([
        'nombre_producto', 'precio',
        'stock', 'categoria', 'descripcion',
    ]));

    return redirect()
        ->route('modulos.validacion')
        ->with('exito', 'Producto registrado.');
}</code></pre>
        </div>
    </div>

    {{-- ═══════════════ PRÁCTICA ═══════════════ --}}
    <div class="space-y-5">

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-bold text-[#1e3a5f] mb-4 flex items-center gap-2">
                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded">PRÁCTICA</span>
                Registro de Producto
            </h2>

            @if (session('exito'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 mb-4 flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('exito') }}
            </div>
            @endif

            {{-- Panel lateral de reglas activas --}}
            <div id="panel-reglas" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4 text-xs hidden">
                <div class="font-semibold text-blue-700 mb-1">Reglas del campo activo:</div>
                <div id="reglas-texto" class="text-blue-600 font-mono"></div>
            </div>

            <form action="{{ route('modulos.validacion.store') }}" method="POST" class="space-y-4"
                  id="form-producto">
                @csrf

                {{-- Nombre producto --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre del producto
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nombre_producto" value="{{ old('nombre_producto') }}"
                           data-reglas="required | string | max:100"
                           placeholder="Ej: Laptop HP 15&quot;"
                           class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $errors->has('nombre_producto') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                    @error('nombre_producto')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Precio y Stock --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Precio (CLP) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="precio" value="{{ old('precio') }}"
                               step="0.01" min="0"
                               data-reglas="required | numeric | min:0"
                               placeholder="0.00"
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                      {{ $errors->has('precio') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('precio')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock') }}"
                               min="0"
                               data-reglas="required | integer | min:0"
                               placeholder="0"
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                      {{ $errors->has('stock') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        @error('stock')
                        <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                {{-- Categoría --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria"
                            data-reglas="required | in:electronico,ropa,alimento,otro"
                            class="w-full border rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500
                                   {{ $errors->has('categoria') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                        <option value="">-- Selecciona --</option>
                        <option value="electronico" {{ old('categoria') === 'electronico' ? 'selected' : '' }}>Electrónico</option>
                        <option value="ropa"        {{ old('categoria') === 'ropa'        ? 'selected' : '' }}>Ropa</option>
                        <option value="alimento"    {{ old('categoria') === 'alimento'    ? 'selected' : '' }}>Alimento</option>
                        <option value="otro"        {{ old('categoria') === 'otro'        ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('categoria')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción (opcional)</label>
                    <textarea name="descripcion" rows="2"
                              data-reglas="nullable | string | max:255"
                              placeholder="Breve descripción del producto..."
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-[#1e3a5f] hover:bg-blue-800 text-white font-semibold py-2.5 rounded-lg text-sm transition-colors">
                    Registrar Producto
                </button>
            </form>
        </div>

        {{-- Tabla de productos --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center justify-between">
                Productos registrados
                <span class="bg-green-100 text-green-700 text-xs font-semibold px-2 py-0.5 rounded-full">
                    {{ $productos->count() }} total
                </span>
            </h3>
            @if ($productos->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">Aún no hay productos registrados.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Producto</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Precio</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Stock</th>
                            <th class="text-left px-3 py-2 font-semibold text-gray-600">Categoría</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($productos as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 font-medium text-gray-800">{{ $p->nombre_producto }}</td>
                            <td class="px-3 py-2 text-gray-700">$ {{ number_format($p->precio, 0, ',', '.') }}</td>
                            <td class="px-3 py-2">
                                <span class="{{ $p->stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }} px-2 py-0.5 rounded">
                                    {{ $p->stock }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded capitalize">{{ $p->categoria }}</span>
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

@push('scripts')
<script>
    // Panel de reglas en tiempo real — muestra las reglas del campo activo
    document.querySelectorAll('#form-producto [data-reglas]').forEach(el => {
        el.addEventListener('focus', () => {
            const panel = document.getElementById('panel-reglas');
            const texto = document.getElementById('reglas-texto');
            const reglas = el.dataset.reglas.split('|').map(r => r.trim());
            texto.innerHTML = reglas.map(r =>
                `<span class="inline-block bg-blue-100 text-blue-700 px-2 py-0.5 rounded mr-1 mb-1">${r}</span>`
            ).join('');
            panel.classList.remove('hidden');
        });
        el.addEventListener('blur', () => {
            document.getElementById('panel-reglas').classList.add('hidden');
        });
    });
</script>
@endpush
@endsection
