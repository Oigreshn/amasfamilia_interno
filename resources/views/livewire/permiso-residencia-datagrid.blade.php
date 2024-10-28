<div class="bg-gray-100 border rounded-lg border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto">

        {{-- Mostrar mensaje de éxito --}}
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
                class="mt-2 text-indigo-500"
            >
                <div class="flex items-center">
                    <!-- Ícono SVG de éxito en indigo -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 10-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <h4 class="font-bold text-indigo-500">¡Éxito!</h4>
                </div>
                <x-input-error :messages="session('success')" class="text-indigo-500 bg-indigo-100 border-indigo-500" />
            </div>
        @endif

        {{-- Mostrar mensaje de error --}}
        @if (session('error'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
                class="mt-2 text-red-500"
            >
                <div class="flex items-center">
                    <!-- Ícono SVG de error en rojo -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-red-500 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>                      
                    <h4 class="font-bold text-red-500">¡Error!</h4>
                </div>
                <x-input-error :messages="session('error')" />
            </div>
        @endif

        {{-- Botón de Agregar un Registro Nuevo --}}
        <div class="p-4 flex mt-4">
            <button 
                class="bg-amber-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-4 py-4 rounded cursor-pointer uppercase flex flex-col items-center"
                wire:click="openCreateModal()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                </svg>
                Agregar un Permiso de Residencia
            </button>
        </div>         

        {{-- Botón de Buscar --}}
        <form wire:submit.prevent='leerDatosFormulario'>
            <div class="p-4 flex">
                <!-- Campo de búsqueda con etiqueta arriba -->
                <div class="flex flex-col w-full md:w-1/2">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar Permiso de Residencia</label>
                    <input 
                        id="termino"
                        type="text"
                        placeholder="Buscar Permiso de Residencia..."
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring 
                        focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-1 uppercase"
                        wire:model="termino"
                    />
                </div>
            </div>            
        </form>
        {{-- Fin de Botón de Buscar --}}

        <!-- Tabla centrada y mejorada -->
        <div class="py-4 overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full table-auto bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-center">ID</th>
                        <th class="px-4 py-2 text-center">Permiso de Residencia</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisosresidencia as $permisoresidencia)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $permisoresidencia->id_permisore }}</td>
                            <td class="px-4 py-2 text-center">{{ $permisoresidencia->descripcion }}</td>
                            <td class="px-4 py-2 text-center">

                                <button wire:click="openCreateModal({{ $permisoresidencia->id_permisore }})" id="edit-btn-{{ $permisoresidencia->id_permisore }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>                                      
                                </button>
                                <button wire:click="eliminarPermisoResidencia({{ $permisoresidencia->id_permisore }})" 
                                    onclick="confirm('¿Seguro de eliminar este Permiso de Residencia?') || event.stopImmediatePropagation()" id="delete-btn-{{ $permisoresidencia->id_permisore }}"
                                    class="bg-red-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>                                      
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>        

        <!-- Paginación centrada -->
        <div class="my-10">
            {{ $permisosresidencia->links('pagination::tailwind') }}
        </div>
    </div>

    {{-- Modal Nuevo Permiso de Residencia --}}
    @if ($modal)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
            <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
                <div class="w-full">
                    <div class="m-8 my-20 max-w-[400px] mx-auto">
                    <div class="mb-4">
                        <h1 class="font-extrabold">Agregar un Permiso de Residencia</h1>
                    </div>
                    <form action="">
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-bold text-gray-700">Permiso de Residencia</label>
                            <input autofocus wire:model="descripcion" type="text" id="descripcion" name="descripcion" 
                                    placeholder="Escriba un Nuevo Permiso de Residencia"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                        </div>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </form>
                    
                    <div class="mb-4 flex flex-row gap-6">
                        <button 
                                class="p-3 bg-black rounded-full text-white w-full font-semibold" 
                                wire:click="createorUpdatePermisoResidencia">{{ isset($miPermisore->id_permisore) ? 'Actualizar' : 'Crear' }} Permiso Residencia</button>
                        <button 
                                class="p-3 bg-white border rounded-full w-full font-semibold" 
                                wire:click.prevent="closeCreateModal">Salir</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>