<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    

    protected $table = 'cuotas'; // Especifica el nombre de la tabla

    protected $fillable = ['cuota_id', 'cliente_id', 'moneda']; // terminar mañaana 

}
