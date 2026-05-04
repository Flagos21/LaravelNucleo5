<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo para los contactos universitarios
class Contacto extends Model
{
    protected $fillable = ['nombre_completo', 'correo_institucional', 'asunto', 'prioridad', 'descripcion'];
}
