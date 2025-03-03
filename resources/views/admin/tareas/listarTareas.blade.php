<x-app-layout>
    <style>
        .dataTables_filter {
            display: none !important;
        }
 /* Estilo para los botones de paginación de DataTables */
.dataTables_wrapper .dataTables_paginate .paginate_button {
    background-color: #007bff; /* Azul */
    color: white !important; /* Texto en blanco */
    border: none; /* Sin bordes */
    padding: 8px 12px; /* Espaciado interno */
    margin: 2px; /* Separación entre botones */
    border-radius: 5px; /* Bordes redondeados */
    cursor: pointer; /* Manito en hover */
    font-weight: bold; /* Texto en negrita */
    transition: background 0.3s ease;
}

/* Cambiar color al pasar el mouse */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background-color: #0056b3; /* Azul más oscuro */
}

/* Estilo para el botón activo */
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
            Listado de Tareas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Lista de Tareas</h3>

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
                            <th class="border border-gray-300 px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tareas as $tarea)
                            <tr class="border border-gray-300 dark:border-gray-600">
                                <td class="px-4 py-2 text-white" >{{ $tarea->id_tarea }}</td>
                                <td class="px-4 py-2 text-white">{{ $tarea->descripcion }}</td>
                                <td class="px-4 py-2">
                                    @if ($tarea->estado === 'S')
                                        <span class="bg-gray-500 text-yell px-3 py-1 rounded-full ">Sin Operario</span>
                                    @elseif ($tarea->estado === 'R')
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full">Realizada</span>
                                    @elseif ($tarea->estado === 'P')
                                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full">Pendiente</span>
                                    @else
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full">{{ $tarea->estado }}</span>
                                    @endif
                                </td>
                                
                                <td class="px-4 py-2 text-white">
                                    <a href="{{ route('tareas.show', $tarea->id_tarea) }}" class="text-blue-500">Ver</a> |
                                    <a href="{{ route('tareas.edit', $tarea->id_tarea) }}" class="text-yellow-500">Editar</a> |
                                    <button class="btnEliminar text-red-500" data-id="{{ $tarea->id_tarea }}">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('tareas.create') }}" class="bg-blue-500 text-white px-4 py-2 mt-4 inline-block rounded">Crear Nueva Tarea</a>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div id="modalConfirmacion" style="display: none;" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg text-center">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">¿Seguro que deseas eliminar esta tarea?</h2>
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

            // Asignar eventos a botones de eliminar
            document.querySelectorAll('.btnEliminar').forEach(button => {
                button.addEventListener('click', function() {
                    let tareaId = this.getAttribute('data-id');
                    mostrarModal(tareaId);
                });
            });

            $('#tareasTable').on('draw.dt', function() {
                document.querySelectorAll('.btnEliminar').forEach(button => {
                    button.addEventListener('click', function() {
                        let tareaId = this.getAttribute('data-id');
                        mostrarModal(tareaId);
                    });
                });
            });
        });

        function mostrarModal(tareaId) {
            document.getElementById('formEliminar').action = '/tareas/' + tareaId;
            document.getElementById('modalConfirmacion').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modalConfirmacion').style.display = 'none';
        }
    </script>
</x-app-layout>
