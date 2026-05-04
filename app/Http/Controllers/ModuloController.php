<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Ficha;
use App\Models\Producto;
use App\Models\SolicitudSoporte;
use Illuminate\Http\Request;

// Controlador principal para los módulos 1, 2 y 3
class ModuloController extends Controller
{
    // ──────────────────────────────────────────────
    // DASHBOARD (Módulo 5 — página principal)
    // ──────────────────────────────────────────────

    public function dashboard()
    {
        // Contadores en tiempo real desde la BD
        $contadores = [
            'fichas'               => Ficha::count(),
            'productos'            => Producto::count(),
            'contactos'            => Contacto::count(),
            'solicitudes_soporte'  => SolicitudSoporte::count(),
        ];

        return view('dashboard.index', compact('contadores'));
    }

    // ──────────────────────────────────────────────
    // MÓDULO 1 — Creación de formularios
    // ──────────────────────────────────────────────

    public function formularios()
    {
        $fichas = Ficha::latest()->get();
        return view('modulos.formularios', compact('fichas'));
    }

    public function guardarFicha(Request $request)
    {
        // Sin validación aún — el propósito del módulo es mostrar
        // cómo crear y enviar el formulario, no cómo validarlo
        Ficha::create($request->only(['nombre', 'email', 'carrera', 'mensaje']));

        return redirect()->route('modulos.formularios')
            ->with('exito', 'Ficha guardada correctamente.');
    }

    // ──────────────────────────────────────────────
    // MÓDULO 2 — Validación de datos
    // ──────────────────────────────────────────────

    public function validacion()
    {
        $productos = Producto::latest()->get();
        return view('modulos.validacion', compact('productos'));
    }

    public function guardarProducto(Request $request)
    {
        // Validación con reglas en formato pipe y array
        $request->validate(
            [
                'nombre_producto' => 'required|string|max:100',
                'precio'          => 'required|numeric|min:0',
                'stock'           => 'required|integer|min:0',
                'categoria'       => 'required|in:electronico,ropa,alimento,otro',
                'descripcion'     => 'nullable|string|max:255',
            ],
            [
                'nombre_producto.required' => 'El nombre del producto es obligatorio.',
                'nombre_producto.max'      => 'El nombre no puede superar los 100 caracteres.',
                'precio.required'          => 'El precio es obligatorio.',
                'precio.numeric'           => 'El precio debe ser un número.',
                'precio.min'               => 'El precio no puede ser negativo.',
                'stock.required'           => 'El stock es obligatorio.',
                'stock.integer'            => 'El stock debe ser un número entero.',
                'stock.min'                => 'El stock no puede ser negativo.',
                'categoria.required'       => 'Debes seleccionar una categoría.',
                'categoria.in'             => 'La categoría seleccionada no es válida.',
                'descripcion.max'          => 'La descripción no puede superar los 255 caracteres.',
            ]
        );

        Producto::create($request->only([
            'nombre_producto', 'precio', 'stock', 'categoria', 'descripcion',
        ]));

        return redirect()->route('modulos.validacion')
            ->with('exito', 'Producto registrado correctamente.');
    }

    // ──────────────────────────────────────────────
    // MÓDULO 3 — Mensajes de error personalizados
    // ──────────────────────────────────────────────

    public function errores()
    {
        $contactos = Contacto::latest()->get();
        return view('modulos.errores', compact('contactos'));
    }

    public function guardarContacto(Request $request)
    {
        // Validación con mensajes completamente personalizados en español
        $request->validate(
            [
                'nombre_completo'       => 'required|string|min:3|max:80',
                'correo_institucional'  => 'required|email|ends_with:unach.cl,adventista.cl',
                'asunto'                => 'required|string|max:120',
                'prioridad'             => 'required|in:baja,media,alta',
                'descripcion'           => 'required|string|min:20',
            ],
            [
                'nombre_completo.required'      => 'El nombre completo es obligatorio.',
                'nombre_completo.min'           => 'El nombre debe tener al menos 3 caracteres.',
                'nombre_completo.max'           => 'El nombre no puede superar los 80 caracteres.',
                'correo_institucional.required' => 'El correo institucional es obligatorio.',
                'correo_institucional.email'    => 'Ingresa un correo electrónico válido.',
                'correo_institucional.ends_with'=> 'El correo debe terminar en @unach.cl o @adventista.cl.',
                'asunto.required'               => 'El asunto es obligatorio.',
                'asunto.max'                    => 'El asunto no puede superar los 120 caracteres.',
                'prioridad.required'            => 'Debes seleccionar una prioridad.',
                'prioridad.in'                  => 'La prioridad seleccionada no es válida.',
                'descripcion.required'          => 'La descripción es obligatoria.',
                'descripcion.min'               => 'La descripción debe tener al menos 20 caracteres.',
            ]
        );

        Contacto::create($request->only([
            'nombre_completo', 'correo_institucional', 'asunto', 'prioridad', 'descripcion',
        ]));

        return redirect()->route('modulos.errores')
            ->with('exito', 'Contacto enviado correctamente.');
    }
}
