<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Formulario de Registro</h3>

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

                <!-- Formulario -->
                <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Correo -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
                        <input type="password" name="password" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <!-- Selección de Rol -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                        <select name="role" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="operario" {{ old('role') == 'operario' ? 'selected' : '' }}>Operario</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('usuarios.index') }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
