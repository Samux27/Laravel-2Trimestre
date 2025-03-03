<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Agregar Nuevo Cliente
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
                <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Teléfono -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Correo Electrónico -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="correo" value="{{ old('correo') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Dirección -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dirección</label>
                        <input type="text" name="direccion" value="{{ old('direccion') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- País -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">País</label>
                        <select name="pais_id" id="pais"  
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Seleccionar País --</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}" data-moneda="{{ $pais->moneda }}">
                                    {{ $pais->nombre }} ({{ $pais->moneda }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Moneda (rellena automáticamente) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Moneda</label>
                        <input type="text" id="moneda" name="moneda" readonly 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Cuenta Corriente -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cuenta Corriente</label>
                        <input type="text" name="cuenta_corriente" value="{{ old('cuenta_corriente') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Importe Cuota -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Importe Cuota</label>
                        <input type="number" name="importe_cuota" step="0.01" value="{{ old('importe_cuota') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Registro</label>
                        <input type="date" name="fecha_registro" value="{{ old('fecha_registro') ?? now()->format('Y-m-d') }}" 
                               class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" >
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end">
                        <a href="{{ route('clientes.index') }}" 
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="ml-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:ring-2 focus:ring-green-400">
                            Guardar Cliente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('pais').addEventListener('change', function() {
            let moneda = this.options[this.selectedIndex].getAttribute('data-moneda');
            document.getElementById('moneda').value = moneda;
        });
    </script>
</x-app-layout>
