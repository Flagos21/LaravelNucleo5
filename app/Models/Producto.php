<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo para los productos del inventario
class Producto extends Model
{
    protected $fillable = ['nombre_producto', 'precio', 'stock', 'categoria', 'descripcion'];
}
