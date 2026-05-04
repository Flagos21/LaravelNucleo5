<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo para las solicitudes de soporte TI
class SolicitudSoporte extends Model
{
    protected $table = 'solicitudes_soporte';

    protected $fillable = [
        'solicitante',
        'email_contacto',
        'tipo_incidente',
        'descripcion_problema',
        'urgencia',
        'equipo_afectado',
    ];
}
