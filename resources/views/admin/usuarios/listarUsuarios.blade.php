<x-app-layout>
    <style>
        .dataTables_filter {
            display: none !important;
        }
        
        /* Estilos para los botones de paginación */
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
            Listado de Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Usuarios Registrados</h3>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Barra de búsqueda -->
                <div class="mb-4 flex justify-end">
                    <input type="text" id="searchInput" placeholder="Buscar usuario..." class="w-1/3 border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Tabla con DataTables -->
                <table id="usuariosTable" class="min-w-full border border-gray-300 dark:border-gray-600">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Nombre</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Rol</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr class="border border-gray-300 dark:border-gray-600">
                                <td class="px-4 py-2 text-white">{{ $usuario->id }}</td>
                                <td class="px-4 py-2 text-white">{{ $usuario->name }}</td>
                                <td class="px-4 py-2 text-white">{{ $usuario->email }}</td>
                                <td class="px-4 py-2 text-white">{{ ucfirst($usuario->role) }}</td>
                                <td class="px-4 py-2 text-white">
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-yellow-500">Editar</a> |
                                    <button class="btnEliminar text-red-500" data-id="{{ $usuario->id }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('usuarios.create') }}" class="bg-blue-500 text-white px-4 py-2 mt-4 inline-block rounded">Crear Nuevo Usuario</a>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div id="modalConfirmacion" style="display: none;" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg text-center">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">¿Seguro que deseas eliminar este usuario?</h2>
            <form id="formEliminar" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded mt-4">Eliminar</button>
                <button type="button" onclick="cerrarModal()" class="bg-gray-400 text-white px-4 py-2 rounded mt-4">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = $('#usuariosTable').DataTable({
                paging: true,
                lengthChange: false,
                info: false,
                responsive: true,
                searching: true,
                language: {
                    zeroRecords: "No se encontraron usuarios",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

            // Conectar la búsqueda personalizada
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Asignar eventos a botones de eliminar
            document.querySelectorAll('.btnEliminar').forEach(button => {
                button.addEventListener('click', function() {
                    let usuarioId = this.getAttribute('data-id');
                    mostrarModal(usuarioId);
                });
            });

            $('#usuariosTable').on('draw.dt', function() {
                document.querySelectorAll('.btnEliminar').forEach(button => {
                    button.addEventListener('click', function() {
                        let usuarioId = this.getAttribute('data-id');
                        mostrarModal(usuarioId);
                    });
                });
            });
        });

        function mostrarModal(usuarioId) {
            document.getElementById('formEliminar').action = '/usuarios/' + usuarioId;
            document.getElementById('modalConfirmacion').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalConfirmacion').style.display = 'none';
        }
    </script>
</x-app-layout>
