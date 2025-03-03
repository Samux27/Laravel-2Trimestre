<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editando Tarea #{{ $tarea->id_tarea }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Formulario de Edición</h3>

                @if ($errors->any())
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="formEditar" action="{{ route('tareas.update', $tarea->id_tarea) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @foreach([
                        'id_cliente' => 'Cliente',
                        'persona_contacto' => 'Persona de Contacto',
                        'telefono_contacto' => 'Teléfono de Contacto',
                        'correo_contacto' => 'Correo de Contacto',
                        'descripcion' => 'Descripción',
                        'direccion' => 'Dirección',
                        'poblacion' => 'Población',
                        'codigo_postal' => 'Código Postal',
                        'provincia' => 'Provincia',
                        
                    ] as $name => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                            <input type="text" name="{{ $name }}" value="{{ old($name, $tarea->$name) }}" required class="form-input">
                        </div>
                    @endforeach

                    <!-- Estado -->
                    <!-- Operario Encargado -->
<div>
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Operario Encargado</label>
    <select name="operario_encargado" required class="form-input">
        <option value="">-- Selecciona un operario --</option>
        @foreach ($operarios as $operario)
            <option value="{{ $operario->id }}" {{ old('operario_encargado', $tarea->operario_encargado) == $operario->id ? 'selected' : '' }}>
                {{ $operario->name }}
            </option>
        @endforeach
    </select>
</div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select name="estado" required class="form-input">
                            <option value="P" {{ old('estado', $tarea->estado) == 'P' ? 'selected' : '' }}>Pendiente</option>
                            <option value="R" {{ old('estado', $tarea->estado) == 'R' ? 'selected' : '' }}>Realizada</option>
                            <option value="S" {{ old('estado', $tarea->estado) == 'S' ? 'selected' : '' }}>Sin Operario</option>
                        </select>
                    </div>

                    <!-- Fecha de Creación (No editable, solo informativa) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Creación</label>
                        <input type="text" value="{{ $tarea->fecha_creacion }}" readonly class="form-input bg-gray-500 cursor-not-allowed">
                    </div>

                    <!-- Fecha de Realización -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Realización</label>
                        <input type="date" name="fecha_realizacion" value="{{ old('fecha_realizacion', $tarea->fecha_realizacion) }}" class="form-input">
                    </div>

                    <!-- Anotaciones Antes y Después -->
                    @foreach([
                        'anotaciones_antes' => 'Anotaciones Antes',
                        'anotaciones_despues' => 'Anotaciones Después'
                    ] as $name => $label)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $label }}</label>
                            <textarea name="{{ $name }}" rows="3" class="form-input">{{ old($name, $tarea->$name) }}</textarea>
                        </div>
                    @endforeach

                    <!-- Fichero Resumen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fichero Resumen <i>pdf,doc,docx,jpg,png</i></label>
                        <input type="file" name="fichero_resumen" class="form-input">
                        @if($tarea->fichero_resumen)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">Archivo actual: <a href="{{ asset('storage/' . $tarea->fichero_resumen) }}" target="_blank" class="text-blue-400 underline">{{ $tarea->fichero_resumen }}</a></p>
                        @endif
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('tareas.listar') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">Cancelar</a>
                        <button type="button" onclick="mostrarModal()" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div id="modalConfirmacion" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg text-center">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">¿Seguro que deseas guardar los cambios?</h2>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Esta acción actualizará la tarea con la nueva información.</p>
            <div class="mt-4">
                <button onclick="document.getElementById('formEditar').submit()" class="bg-blue-500 text-white px-4 py-2 rounded">Confirmar</button>
                <button type="button" onclick="cerrarModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </div>
    </div>

    <!-- SCRIPT PARA MANEJAR EL MODAL -->
    <script>
        function mostrarModal() {
            document.getElementById('modalConfirmacion').classList.remove('hidden');
        }

        function cerrarModal() {
            document.getElementById('modalConfirmacion').classList.add('hidden');
        }
    </script>

    <style>
        .form-input {
            width: 100%;
            border: 1px solid #4a5568;
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 0.5rem;
            border-radius: 0.375rem;
            outline: none;
            focus:ring-blue-500 focus:border-blue-500;
        }
    </style>
</x-app-layout>
