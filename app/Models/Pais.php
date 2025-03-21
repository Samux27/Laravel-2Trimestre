<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises'; // Especifica el nombre de la tabla

    protected $fillable = ['nombre', 'codigo_iso', 'moneda'];

}
