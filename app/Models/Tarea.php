<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas'; // Nombre exacto de la tabla en la BD

    protected $primaryKey = 'id_tarea'; // Clave primaria

    public $timestamps = false; // Laravel no gestionará created_at ni updated_at

    protected $fillable = [
        'id_cliente', 'persona_contacto', 'telefono_contacto', 
        'descripcion', 'correo_contacto', 'direccion', 'poblacion', 
        'codigo_postal', 'provincia', 'estado', 'fecha_realizacion', 
        'operario_encargado', 'anotaciones_antes', 'anotaciones_despues', 'fichero_resumen'
    ];
}
