<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo para las fichas de estudiantes
class Ficha extends Model
{
    protected $fillable = ['nombre', 'email', 'carrera', 'mensaje'];
}
