<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js (para funcionalidades interactivas) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ingrese sus datos para continuar</h3>

            <!-- Mostrar mensaje de error general -->
            @if(session('error'))
                <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Formulario -->
            <form action="{{ route('verificar.datos') }}" method="POST">
                @csrf

                <!-- Correo Electrónico -->
                <div class="mb-4">
                    <label for="correo" class="block text-gray-700 dark:text-gray-300 font-semibold">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo') }}"
                        class="w-full border @error('correo') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror 
                        bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    
                    @error('correo')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 dark:text-gray-300 font-semibold">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                        class="w-full border @error('nombre') border-red-500 @else border-gray-300 dark:border-gray-600 @enderror 
                        bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    @error('nombre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Verificar</button>
                </div>
            </form>
        </div>
    </div>
</div>
