<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarea; // Importar el modelo
use Illuminate\Support\Facades\Storage;
use App\Models\User;
class TareasController extends Controller
{
    public function index()
    {
        $tareas = Tarea::orderByRaw("FIELD(estado, 'S', 'P', 'R')")->get(); // Obtener todas las tareas
        return view('admin.tareas.listarTareas', compact('tareas'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'id_cliente' => 'required|string',
            'persona_contacto' => 'required|string|max:150',
            'telefono_contacto' => 'required|string|max:50',
            'correo_contacto' => 'required|email|max:100',
            'descripcion' => 'required|string',
            'direccion' => 'required|string',
            'poblacion' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:10',
            'provincia' => 'required|string',
            'estado' => 'required|in:P,R,C',
            'fecha_realizacion' => 'nullable|date|after_or_equal:today',
            'operario_encargado' => 'nullable|string',
            'anotaciones_antes' => 'nullable|string',
            'anotaciones_despues' => 'nullable|string',
           'fichero_resumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048'
        ]);

        $tarea = Tarea::create($request->except('fichero_resumen'));

        // Guardar el archivo en una carpeta con el ID de la tarea
        if ($request->hasFile('fichero_resumen')) {
            $nombreArchivo = time() . '_' . $request->file('fichero_resumen')->getClientOriginalName();
            $rutaArchivo = $request->file('fichero_resumen')->storeAs("tareas/{$tarea->id_tarea}", $nombreArchivo, 'public');
            
            // Actualizar la tarea con la ruta del archivo
            $tarea->update(['fichero_resumen' => $rutaArchivo]);
        }
        // Redirigir a la lista de tareas con mensaje de éxito
        return redirect()->route('tareas.index')->with('success', 'Tarea creada correctamente.');
    }
    //mostrar tarea especifica
    public function show($id)
    {
        $tarea = Tarea::findOrFail($id);
        return view('admin.tareas.mostrarTarea', compact('tarea')); //comprar devuelve array simetrico tarea -> $tarea
    }
 // ✅ 4️⃣ Actualizar tarea
 public function update(Request $request, $id)
 {
     $tarea = Tarea::findOrFail($id);
 
     // Validación de datos
     $request->validate([
         'id_cliente' => 'required|string',
         'persona_contacto' => 'required|string|max:150',
         'telefono_contacto' => 'required|string|max:50',
         'correo_contacto' => 'required|email|max:100',
         'descripcion' => 'required|string',
         'direccion' => 'required|string',
         'poblacion' => 'required|string|max:100',
         'codigo_postal' => 'required|string|max:10',
         'provincia' => 'required|string',
         'estado' => 'required|in:P,R,S',
         'fecha_realizacion' => 'nullable|date|after_or_equal:today',
         'operario_encargado' => 'nullable|exists:users,id', // Asegura que el operario existe en la tabla users
         'anotaciones_antes' => 'nullable|string',
         'anotaciones_despues' => 'nullable|string',
         'fichero_resumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048'
     ]);
 
     // Actualizar los campos de la tarea
     $tarea->update([
         'id_cliente' => $request->id_cliente,
         'persona_contacto' => $request->persona_contacto,
         'telefono_contacto' => $request->telefono_contacto,
         'correo_contacto' => $request->correo_contacto,
         'descripcion' => $request->descripcion,
         'direccion' => $request->direccion,
         'poblacion' => $request->poblacion,
         'codigo_postal' => $request->codigo_postal,
         'provincia' => $request->provincia,
         'estado' => $request->estado,
         'fecha_realizacion' => $request->fecha_realizacion,
         'operario_encargado' => $request->operario_encargado, // Actualiza el operario correctamente
         'anotaciones_antes' => $request->anotaciones_antes,
         'anotaciones_despues' => $request->anotaciones_despues,
     ]);
 
     // Manejo del archivo de resumen
     if ($request->hasFile('fichero_resumen')) {
         // Eliminar el archivo anterior si existe
         if ($tarea->fichero_resumen) {
             Storage::disk('public')->delete($tarea->fichero_resumen);
         }
 
         // Guardar el nuevo archivo
         $nombreArchivo = time() . '_' . $request->file('fichero_resumen')->getClientOriginalName();
         $rutaArchivo = $request->file('fichero_resumen')->storeAs("tareas/{$tarea->id_tarea}", $nombreArchivo, 'public');
 
         // Actualizar la tarea con la nueva ruta del archivo
         $tarea->update(['fichero_resumen' => $rutaArchivo]);
     }
 
     return redirect()->route('tareas.index')->with('success', 'Tarea actualizada correctamente.');
 }
 

 // ✅ 5️⃣ Eliminar tarea
 public function destroy($id)
 {
       // Buscar la tarea completa por su ID
       $tarea = Tarea::findOrFail($id);

       // Eliminar archivos relacionados antes de borrar la tarea
       if ($tarea->fichero_resumen) {
           Storage::disk('public')->delete($tarea->fichero_resumen);
       }
   
       // Eliminar la carpeta completa de la tarea
       Storage::disk('public')->deleteDirectory("tareas/{$tarea->id_tarea}");
   
       // Eliminar la tarea de la base de datos
       $tarea->delete();
   
     return redirect()->route('tareas.index')->with('success', 'Tarea eliminada correctamente.');
 }
 public function create(){
    $operarios = User::where('role', 'operario')->get();
    return view('admin.tareas.insertarTarea' ,compact('operarios'));
 }
 public function edit($id){
    $tarea = Tarea::findOrFail($id);
    $operarios = User::where('role', 'operario')->get();
    return view('admin.tareas.editarTarea',compact('tarea','operarios'));
 }
}
