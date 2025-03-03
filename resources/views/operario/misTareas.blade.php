<x-app-layout>
    <style>
        .dataTables_filter {
            display: none !important;
        }

        /* Estilo para los botones de paginación de DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #007bff; /* Azul */
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
            background-color: #0056b3; /* Azul más oscuro */
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #28a745; /* Verde */
            color: white !important;
            font-weight: bold;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.tailwindcss.min.js"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Mis Tareas Asignadas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lista de Mis Tareas</h3>

                @if(session('success'))
                    <div class="bg-green-500 text-white p-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Campo de búsqueda -->
                <div class="mb-4 flex justify-end">
                    <input type="text" id="searchInput" placeholder="Buscar tarea..." class="w-1/3 border border-gray-400 dark:border-gray-600 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                </div>

                <!-- Tabla con DataTables -->
                <table id="tareasTable" class="min-w-full border border-gray-300 dark:border-gray-600">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Descripción</th>
                            <th class="border border-gray-300 px-4 py-2">Estado</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha Asignada</th>
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tareas as $tarea)
                            <tr class="border border-gray-300 dark:border-gray-600">
                                <td class="px-4 py-2 text-white">{{ $tarea->id_tarea }}</td>
                                <td class="px-4 py-2 text-white">{{ $tarea->descripcion }}</td>
                                <td class="px-4 py-2 text-white">
                                    @if ($tarea->estado === 'S')
                                        Sin Operario
                                    @elseif ($tarea->estado === 'R')
                                        Realizada
                                    @elseif ($tarea->estado === 'P')
                                        Pendiente
                                    @else
                                        {{ $tarea->estado }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-white">{{ $tarea->fecha_creacion}}</td>
                                <td class="px-4 py-2 text-white">
                                    <a href="{{ route('tareas.show', $tarea->id_tarea) }}" class="text-blue-500 hover:underline">Ver</a> |
                                    <a href="{{ route('operario.completar', $tarea->id_tarea) }}" class="text-green-500 hover:underline">Completar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let table = $('#tareasTable').DataTable({
                paging: true,
                lengthChange: false,
                info: false,
                responsive: true,
                searching: true,
                language: {
                    zeroRecords: "No se encontraron tareas",
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
        });
    </script>
</x-app-layout>
