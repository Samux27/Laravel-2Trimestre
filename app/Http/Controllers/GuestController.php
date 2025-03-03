<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Tarea;
use Illuminate\Support\Facades\Session;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos ingresados por el cliente
        $request->validate([
            'descripcion' => 'required|string|max:1000',
            'direccion' => 'required|string|max:255',
        ]);

        // Obtener los datos del cliente desde la sesión
        $cliente_sesion = Session::get('cliente_validado');

        // Si el cliente no está en la sesión, redirigir a la verificación
        if (!$cliente_sesion) {
            return redirect()->route('verificar.datos')->with('error', 'Por favor, verifique sus datos antes de crear una tarea.');
        }

        // Buscar al cliente en la base de datos para obtener más información
        $cliente = Cliente::where('id_cliente', $cliente_sesion['id_cliente'])->first();

        // Si el cliente no existe en la base de datos, redirigir con error
        if (!$cliente) {
            return redirect()->route('verificar.datos')->with('error', 'Hubo un problema al recuperar sus datos. Verifique nuevamente.');
        }

        // Crear la nueva tarea con los datos completos del cliente
        Tarea::create([
            'id_cliente' => $cliente->id_cliente,
            'persona_contacto' => $cliente->nombre, 
            'telefono_contacto' => $cliente->telefono, 
            'correo_contacto' => $cliente->correo, 
            'descripcion' => $request->descripcion, 
            'direccion' => $request->direccion, 
            'poblacion' => $cliente->poblacion ?? 'Desconocido', 
            'codigo_postal' => $cliente->codigo_postal ?? null, 
            'provincia' => $cliente->provincia ?? 'Desconocido', 
            'estado' => 'S', // Estado inicial: Pendiente
            'fecha_creacion' => now(), // Fecha actual
            'operario_encargado' => null, 
            'fecha_realizacion' => null, 
            'anotaciones_antes' => null,
            'anotaciones_despues' => null,
            'fichero_resumen' => null,
        ]);

        // Limpiar la sesión después de crear la tarea (opcional)
        Session::forget('cliente_validado');

        // Redirigir con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Tarea creada exitosamente.');
    }
    public function verificar(Request $request)
    {
        // Validación de los datos ingresados
        $request->validate([
            'correo' => 'required|email',
            'nombre' => 'required|string|max:20',
        ]);

        // Buscar al cliente en la base de datos
        $cliente = Cliente::where('correo', $request->correo)
                          ->where('nombre', $request->nombre)
                          ->first();

        if ($cliente) {
            Session::put('cliente_validado', [
                'id_cliente' => $cliente->id_cliente,
                'nombre' => $cliente->nombre,
                'correo' => $cliente->correo,
                'telefono' => $cliente->telefono,
            ]);
            // Si el cliente existe, redirigir a la creación de tareas con su ID
            return redirect()->route('verificar.create', ['cliente_id' => $cliente->id_cliente]);
        } else {
            // Si no se encuentra, mostrar un mensaje de error
            return redirect()->back()->with('error', 'Los datos ingresados no coinciden con ningún cliente.');
        }
    }
}
