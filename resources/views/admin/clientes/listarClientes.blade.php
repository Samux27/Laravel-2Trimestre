<x-app-layout>
    <style>
        .dataTables_filter {
            display: none !important;
        }

        /* Estilo para los botones de paginación de DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #007bff;
            color: white !important;
            border: none;
            padding: 8px 12px;
            margin: 2px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #28a745;
            color: white !important;
            font-weight: bold;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.tailwindcss.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Listado de Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Clientes Registrados</h3>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Campo de búsqueda -->
                <div class="mb-4 flex justify-between">
                    <a href="{{ route('clientes.create') }}" class="bg-blue-500 text-white px-4 py-2 mt-4 inline-block rounded">Nuevo Cliente </a>
                    <input type="text" id="searchInput" placeholder="Buscar cliente..." class="w-1/3 border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Tabla con DataTables -->
                <table id="clientesTable" class="min-w-full border border-gray-300 dark:border-gray-600">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nombre</th>
                            <th class="border border-gray-300 px-4 py-2">Correo</th>
                            <th class="border border-gray-300 px-4 py-2">Teléfono</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr class="border border-gray-300 dark:border-gray-600">
                                <td class="px-4 py-2 text-white">{{ $cliente->id_cliente }}</td>
                                <td class="px-4 py-2 text-white">{{ $cliente->nombre }}</td>
                                <td class="px-4 py-2 text-white">{{ $cliente->correo }}</td>
                                <td class="px-4 py-2 text-white">{{ $cliente->telefono }}</td>
                                <td class="px-4 py-2 text-white">
                                    
                                    <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="text-yellow-500">Editar</a> |
                                    <button onclick="mostrarModalEliminar({{ $cliente->id_cliente }})" class="text-red-500 hover:underline ml-2">Eliminar</button>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    
    <!-- MODAL PARA ELIMINAR CLIENTE -->
<div id="modalEliminar" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg text-center">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">¿Seguro que deseas eliminar este cliente?</h2>
        <p class="text-gray-600 dark:text-gray-300 mt-2">Esta acción no se puede deshacer.</p>
        <form id="formEliminar" method="POST">
            @csrf
            @method('DELETE')
            <div class="mt-4">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                <button type="button" onclick="cerrarModalEliminar()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancelar</button>
            </div>
        </form>
    </div>
</div>

    <!-- SCRIPT -->
    <script>
          function mostrarModalEliminar(clienteId) {
        let formEliminar = document.getElementById('formEliminar');
        formEliminar.action = '/clientes/'+clienteId; 
        document.getElementById('modalEliminar').classList.remove('hidden');
    }

    function cerrarModalEliminar() {
        document.getElementById('modalEliminar').classList.add('hidden');
    }
        document.addEventListener('DOMContentLoaded', function() {
            let table = $('#clientesTable').DataTable({
                paging: true,
                lengthChange: false,
                info: false,
                responsive: true,
                searching: true,
                language: {
                    zeroRecords: "No se encontraron clientes",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });

        function mostrarModalCrear() {
            document.getElementById('modalCrear').classList.remove('hidden');
        }

        function cerrarModalCrear() {
            document.getElementById('modalCrear').classList.add('hidden');
        }
    </script>
</x-app-layout>
