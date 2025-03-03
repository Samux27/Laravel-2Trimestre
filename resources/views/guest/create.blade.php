
<script src="https://cdn.tailwindcss.com"></script>

<!-- Alpine.js (para funcionalidades interactivas) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js"></script>

   <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Crear Nueva Tarea
        </h2>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Ingrese los datos de la tarea</h3>

                @if(session('error'))
                    <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('guest.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <p class="text-gray-700 dark:text-gray-300 font-semibold">Cliente: {{ session('cliente_validado.nombre') }}</p>
                        <p class="text-gray-700 dark:text-gray-300">Correo: {{ session('cliente_validado.correo') }}</p>
                        <p class="text-gray-700 dark:text-gray-300">Teléfono: {{ session('cliente_validado.telefono') }}</p>
                    </div>
                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 dark:text-gray-300 font-semibold">Descripción de la Tarea</label>
                        <textarea name="descripcion" id="descripcion" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"></textarea>
                    </div>

                    <!-- Dirección -->
                    <div class="mb-4">
                        <label for="direccion" class="block text-gray-700 dark:text-gray-300 font-semibold">Dirección</label>
                        <input type="text" name="direccion" id="direccion" required
                            class="w-full border-gray-300 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between mt-6">
                        <a href="{{ route('dashboard') }}" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Tarea</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

