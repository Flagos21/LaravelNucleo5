<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request para la solicitud de soporte TI.
 * Encapsula la validación fuera del controlador.
 */
class SoporteRequest extends FormRequest
{
    // Autoriza a todos los usuarios (app pública sin autenticación)
    public function authorize(): bool
    {
        return true;
    }

    // Reglas de validación del formulario
    public function rules(): array
    {
        return [
            'solicitante'          => 'required|string|max:100',
            'email_contacto'       => 'required|email',
            'tipo_incidente'       => 'required|in:hardware,software,red,otro',
            'descripcion_problema' => 'required|string|min:30|max:500',
            'urgencia'             => 'required|in:baja,media,alta,critica',
            'equipo_afectado'      => 'nullable|string|max:100',
        ];
    }

    // Mensajes de error personalizados en español
    public function messages(): array
    {
        return [
            'solicitante.required'          => 'El nombre del solicitante es obligatorio.',
            'solicitante.max'               => 'El nombre no puede superar los 100 caracteres.',
            'email_contacto.required'       => 'El correo de contacto es obligatorio.',
            'email_contacto.email'          => 'Ingresa un correo electrónico válido.',
            'tipo_incidente.required'       => 'Debes seleccionar un tipo de incidente.',
            'tipo_incidente.in'             => 'El tipo de incidente no es válido.',
            'descripcion_problema.required' => 'La descripción del problema es obligatoria.',
            'descripcion_problema.min'      => 'La descripción debe tener al menos 30 caracteres.',
            'descripcion_problema.max'      => 'La descripción no puede superar los 500 caracteres.',
            'urgencia.required'             => 'Debes seleccionar el nivel de urgencia.',
            'urgencia.in'                   => 'El nivel de urgencia no es válido.',
            'equipo_afectado.max'           => 'El nombre del equipo no puede superar los 100 caracteres.',
        ];
    }

    // Nombres de atributos amigables para los mensajes
    public function attributes(): array
    {
        return [
            'solicitante'          => 'nombre del solicitante',
            'email_contacto'       => 'correo de contacto',
            'tipo_incidente'       => 'tipo de incidente',
            'descripcion_problema' => 'descripción del problema',
            'urgencia'             => 'urgencia',
            'equipo_afectado'      => 'equipo afectado',
        ];
    }
}
