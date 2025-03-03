<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Pais;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.clientes.listarClientes',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises=Pais::all();
    return view('admin.clientes.insertarClientes',compact("paises"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
   
    // Validación de los datos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'telefono' => 'required|string|max:20',
        'correo' => 'required|email|unique:clientes',
        'direccion' => 'required|string|max:255',
        'pais_id' => 'required|exists:paises,id', // Asegura que el país existe en la base de datos
        'cuenta_corriente' => 'required|string|max:50',
        'importe_cuota' => 'required|numeric|min:0',
        'fecha_registro' => 'required|date',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'telefono.required' => 'El teléfono es obligatorio.',
        'correo.required' => 'El correo es obligatorio.',
        'correo.email' => 'El correo debe ser válido.',
        'correo.unique' => 'Este correo ya está registrado.',
        'direccion.required' => 'La dirección es obligatoria.',
        'pais_id.required' => 'El país es obligatorio.',
        'pais_id.exists' => 'El país seleccionado no es válido.',
        'cuenta_corriente.required' => 'La cuenta corriente es obligatoria.',
        'importe_cuota.required' => 'El importe de la cuota es obligatorio.',
        'importe_cuota.numeric' => 'El importe debe ser un número.',
        'importe_cuota.min' => 'El importe no puede ser negativo.',
        'fecha_registro.required' => 'La fecha de registro es obligatoria.',
        'fecha_registro.date' => 'La fecha debe ser válida.',
    ]);
    
    // Obtener el país seleccionado
   

    // Crear el cliente
    Cliente::create([
        'nombre' => $request->nombre,
        'telefono' => $request->telefono,
        'correo' => $request->correo,
        'direccion' => $request->direccion,
        'pais_id' => $request->pais_id,
        'cuenta_corriente' => $request->cuenta_corriente,
        'importe_cuota' => $request->importe_cuota,
        'fecha_registro' => $request->fecha_registro,
        'moneda'=>$request->moneda,
    ]);
    
    return redirect()->route('clientes.index')->with('success', 'Cliente agregado correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clientes = Cliente::findOrFail($id);
        $paises= Pais::all();
        
        return view('admin.clientes.editarClientes',compact('clientes','paises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
    // Validación de los datos enviados en el formulario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'correo' => 'required|email|max:255|unique:clientes,correo,' . $id . ',id_cliente',
        'telefono' => 'required|string|max:20',
        'pais' => 'required|exists:paises,id',
    ]);

    // Buscar al cliente por su ID
    $cliente = Cliente::where('id_cliente', $id)->first();

    // Verificar si el cliente existe
    if (!$cliente) {
        return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado.');
    }

    // Actualizar los datos del cliente
    $cliente->update([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'telefono' => $request->telefono,
        'pais_id' => $request->pais,
    ]);

    // Redirigir con un mensaje de éxito
    return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    $cliente = Cliente::find($id);

    // Verificar si existe
    if (!$cliente) {
        return redirect()->route('clientes.index')->with('error', 'Cliente no encontrado.');
    }

    // Eliminar el cliente
    $cliente->delete();

    return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
