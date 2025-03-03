<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalles de la Tarea
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Información de la Tarea</h3>

                <!-- ID Cliente -->
                <p class="text-gray-700 dark:text-gray-300"><strong>ID Cliente:</strong> {{ $tarea->id_cliente }}</p>

                <!-- Persona de Contacto -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Persona de Contacto:</strong> {{ $tarea->persona_contacto }}</p>

                <!-- Teléfono de Contacto -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Teléfono:</strong> {{ $tarea->telefono_contacto }}</p>

                <!-- Correo de Contacto -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Correo:</strong> {{ $tarea->correo_contacto }}</p>

                <!-- Descripción -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Descripción:</strong> {{ $tarea->descripcion }}</p>

                <!-- Dirección -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Dirección:</strong> {{ $tarea->direccion }}</p>

                <!-- Población -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Población:</strong> {{ $tarea->poblacion }}</p>

                <!-- Código Postal -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Código Postal:</strong> {{ $tarea->codigo_postal }}</p>

                <!-- Provincia -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Provincia:</strong> {{ $tarea->provincia }}</p>

                <!-- Estado -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Estado:</strong> 
                    @if($tarea->estado == 'P')
                        Pendiente
                    @elseif($tarea->estado == 'R')
                        Realizada
                    @elseif($tarea->estado == 'C')
                        Cancelada
                    @endif
                </p>

                <!-- Fecha de Realización -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Fecha de Realización:</strong> 
                    {{ $tarea->fecha_realizacion ? $tarea->fecha_realizacion : 'No definida' }}
                </p>

                <!-- Operario Encargado -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Operario Encargado:</strong> 
                    {{ $tarea->operario_encargado ? $tarea->operario_encargado : 'No asignado' }}
                </p>

                <!-- Anotaciones Antes -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Anotaciones Antes:</strong> 
                    {{ $tarea->anotaciones_antes ? $tarea->anotaciones_antes : 'No hay anotaciones previas' }}
                </p>

                <!-- Anotaciones Después -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Anotaciones Después:</strong> 
                    {{ $tarea->anotaciones_despues ? $tarea->anotaciones_despues : 'No hay anotaciones posteriores' }}
                </p>

                <!-- Archivo Resumen -->
                <p class="text-gray-700 dark:text-gray-300"><strong>Fichero Resumen:</strong> 
                    @if($tarea->fichero_resumen)
                        <a href="{{ asset('storage/'.$tarea->fichero_resumen) }}" class="text-blue-500" target="_blank">Ver Archivo</a>
                    @else
                        No hay archivo adjunto
                    @endif
                </p>

                <!-- Botón de Volver -->
                <a href="{{ auth()->user()->role === 'admin' ? route('tareas.listar') : route('operario.index') }}" class="text-blue-500 mt-4 inline-block">
                    Volver
                </a>
                
            </div>
        </div>
    </div>
</x-app-layout>
