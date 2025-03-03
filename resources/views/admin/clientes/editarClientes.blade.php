<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Cliente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Modificar Cliente</h3>

                <!-- Mostrar mensajes de éxito o error -->
                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Formulario de edición -->
                <form action="{{ route('clientes.update', $clientes->id_cliente) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 dark:text-gray-300 font-semibold">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $clientes->nombre) }}" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <!-- Correo -->
                    <div class="mb-4">
                        <label for="correo" class="block text-gray-700 dark:text-gray-300 font-semibold">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo', $clientes->correo) }}" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-4">
                        <label for="telefono" class="block text-gray-700 dark:text-gray-300 font-semibold">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $clientes->telefono) }}" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <!-- Selección de País -->
                    <div class="mb-4">
                        <label for="pais" class="block text-gray-700 dark:text-gray-300 font-semibold">País</label>
                        <select name="pais" id="pais" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            <option value="" disabled>Seleccione un país</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}" {{ $clientes->pais_id == $pais->id ? 'selected' : '' }}>
                                    {{ $pais->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('clientes.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
