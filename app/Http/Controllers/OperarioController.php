<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\Tarea;

class OperarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $tareas= Tarea::all();
        return view('operario.listarTareasOperario', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }
    public function misTareas()
{
    $userId = auth()->id(); // Obtiene el ID del usuario autenticado
    $tareas = Tarea::where('operario_encargado', $userId)
               ->whereNotIn('estado', ['R']) // Excluye Realizadas y Canceladas
               ->get(); // Filtra las tareas asignadas a este operario

    return view('operario.misTareas', compact('tareas'));
}
public function completar($id)
{
    $tarea = Tarea::findOrFail($id);

    return view('operario.realizarTareaOperaio', compact('tarea'));
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tarea = Tarea::findOrFail($id);
        return view('operario.realizarTareaOperaio', compact('tarea')); //comprar devuelve array simetrico tarea -> $tarea
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

   

public function update(Request $request, string $id)
{
    // Buscar la tarea
    $tarea = Tarea::findOrFail($id);

    // Validación del formulario
    $request->validate([
        'estado' => 'required|in:P,R',
        'fecha_realizacion' => $request->estado === 'R' ? 'required|date|before_or_equal:today' : 'nullable|date',
        'anotaciones_antes' => 'nullable|string|max:1000',
        'anotaciones_despues' => 'nullable|string|max:1000',
        'fichero_resumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048'
    ], [
        'estado.required' => 'El estado es obligatorio.',
        'estado.in' => 'El estado debe ser Pendiente (P) o Realizada (R).',
        'fecha_realizacion.required' => 'Debes ingresar una fecha si la tarea fue realizada.',
        'fecha_realizacion.date' => 'Ingresa una fecha válida.',
        'fecha_realizacion.before_or_equal' => 'La fecha no puede ser futura.',
        'anotaciones_antes.max' => 'Las anotaciones antes no pueden superar los 1000 caracteres.',
        'anotaciones_despues.max' => 'Las anotaciones después no pueden superar los 1000 caracteres.',
        'fichero_resumen.mimes' => 'El archivo debe ser PDF, DOC, DOCX, JPG o PNG.',
        'fichero_resumen.max' => 'El archivo no debe superar los 2MB.'
    ]);

    // Actualizar los campos de la tarea
    $tarea->update([
        'estado' => $request->estado,
        'fecha_realizacion' => $request->fecha_realizacion,
        'anotaciones_antes' => $request->anotaciones_antes,
        'anotaciones_despues' => $request->anotaciones_despues,
    ]);

    // Manejo del archivo resumen si se sube uno nuevo
    if ($request->hasFile('fichero_resumen')) {
        // Eliminar el archivo anterior si existe
        if ($tarea->fichero_resumen) {
            Storage::disk('public')->delete($tarea->fichero_resumen);
        }

        // Guardar el nuevo archivo en el almacenamiento público
        $nombreArchivo = time() . '_' . $request->file('fichero_resumen')->getClientOriginalName();
        $rutaArchivo = $request->file('fichero_resumen')->storeAs("tareas/{$tarea->id_tarea}", $nombreArchivo, 'public');

        // Actualizar la tarea con la nueva ruta del archivo
        $tarea->update(['fichero_resumen' => $rutaArchivo]);
    }

    return redirect()->route('operario.index')->with('success', 'Tarea actualizada correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
