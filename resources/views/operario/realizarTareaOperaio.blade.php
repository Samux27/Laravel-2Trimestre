<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modificar Tarea #{{ $tarea->id_tarea }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Actualizar Información</h3>

                <!-- Mostrar errores de validación -->
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulario de edición -->
                <form id="formEditar" action="{{ route('operario.update', $tarea->id_tarea) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Estado -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select name="estado" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="P" {{ old('estado', $tarea->estado) == 'P' ? 'selected' : '' }}>Pendiente</option>
                            <option value="R" {{ old('estado', $tarea->estado) == 'R' ? 'selected' : '' }}>Realizada</option>
                            <option value="C" {{ old('estado', $tarea->estado) == 'C' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                    </div>

                    <!-- Fecha de Realización -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Realización</label>
                        <input type="date" name="fecha_realizacion" value="{{ old('fecha_realizacion', $tarea->fecha_realizacion) }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                   

                    <!-- Anotaciones Antes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Anotaciones Antes</label>
                        <textarea name="anotaciones_antes" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('anotaciones_antes', $tarea->anotaciones_antes) }}</textarea>
                    </div>

                    <!-- Anotaciones Después -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Anotaciones Después</label>
                        <textarea name="anotaciones_despues" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('anotaciones_despues', $tarea->anotaciones_despues) }}</textarea>
                    </div>

                    <!-- Fichero Resumen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fichero Resumen</label>
                        <input type="file" name="fichero_resumen" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('tareas.listar') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">Cancelar</a>
                        <button type="button" onclick="mostrarModal()" class="ml-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
                            Completar
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
</x-app-layout>
