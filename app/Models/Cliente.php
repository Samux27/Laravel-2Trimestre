<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes'; // Nombre exacto de la tabla en la BD

    protected $primaryKey = 'id_cliente'; // ✅ Nombre correcto
 // Clave primaria

    public $timestamps = false; // Laravel no gestionará created_at ni updated_at

    protected $fillable = [
        'id_cliente', 'nombre', 'telefono', 
        'correo', 'direccion','moneda',
        'cuenta_corriente', 'importe_cuota', 'fecha_registro','pais_id'
    ];
}
