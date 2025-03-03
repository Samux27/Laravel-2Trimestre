<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $usuarios = User::all(); // Obtener todas las tareas
            return view('admin.usuarios.listarUsuarios', compact('usuarios'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
        return view('admin.usuarios.insertarUsuarios');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,operario',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // 🔹 Encriptar la contraseña
            'role' => $request->role,
        ]);
    
        return redirect()->route('usuarios.listar')->with('success', 'Usuario creado correctamente.');
    }
    

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $usuario = User::findOrFail($id);
     // 🔹 Muestra los datos en pantalla
    return view('admin.usuarios.editarUsuarios', compact('usuario'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // ✅ 1. Validar los datos ingresados
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
        'role' => 'required|in:admin,operario',
    ]);

    // ✅ 2. Buscar el usuario a actualizar
    $usuario = User::findOrFail($id);

    // ✅ 3. Actualizar los datos
    $usuario->name = $request->name;
    $usuario->email = $request->email;
    $usuario->role = $request->role;

    // ✅ 4. Si se proporciona una nueva contraseña, la encripta
    if ($request->filled('password')) {
        $usuario->password = bcrypt($request->password);
    }

    // ✅ 5. Guardar los cambios en la base de datos
    $usuario->save();

    // ✅ 6. Redirigir con un mensaje de éxito
    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
  
       // Buscar la tarea completa por su ID
       $usuario = User::findOrFail($id);

     
       // Eliminar la tarea de la base de datos
       $usuario->delete();
   
     return redirect()->route('usuarios.index')->with('success', 'Tarea eliminada correctamente.');
    }
}
