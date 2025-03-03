<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Usuario: {{ $usuario->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Formulario de Edición</h3>

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

                <!-- Formulario de Edición -->
                <form id="formEditar" action="{{ route('usuarios.update', $usuario->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $usuario->name) }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Contraseña (Opcional) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Contraseña (Opcional)</label>
                        <input type="password" name="password" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <small class="text-gray-400 dark:text-gray-500">Déjalo en blanco si no deseas cambiar la contraseña.</small>
                    </div>

                    <!-- Selección de Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                        <select name="role" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="operario" {{ old('role', $usuario->role) == 'operario' ? 'selected' : '' }}>Operario</option>
                            <option value="admin" {{ old('role', $usuario->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('usuarios.index') }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                            Cancelar
                        </a>
                        <button type="button" onclick="mostrarModal()" 
                                class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
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
            <p class="text-gray-600 dark:text-gray-300 mt-2">Esta acción actualizará los datos del usuario.</p>
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
