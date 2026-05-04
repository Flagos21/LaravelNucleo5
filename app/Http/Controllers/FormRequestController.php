<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoporteRequest;
use App\Models\SolicitudSoporte;

// Controlador para el Módulo 4 — Form Request Objects
class FormRequestController extends Controller
{
    // Muestra el formulario y la lista de solicitudes guardadas
    public function index()
    {
        $solicitudes = SolicitudSoporte::latest()->get();
        return view('modulos.form-request', compact('solicitudes'));
    }

    // Almacena la solicitud usando SoporteRequest (la validación ocurre
    // automáticamente antes de que se ejecute este método)
    public function store(SoporteRequest $request)
    {
        SolicitudSoporte::create($request->validated());

        return redirect()->route('modulos.form-request')
            ->with('exito', 'Solicitud de soporte registrada correctamente.');
    }
}
