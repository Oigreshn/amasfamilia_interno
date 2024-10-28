<div class="bg-gray-100 border rounded-lg border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto">

        {{-- Mostrar mensaje de éxito --}}
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
            >
                <div class="max-w-lg mx-auto">    
                    <div class="flex bg-blue-100 rounded-lg p-4 mb-4 text-sm text-blue-700" role="alert">
                        <!-- Ícono SVG de éxito en azul -->
                        <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <span class="font-medium">¡Éxito!</span>
                            <p class="text-blue-700 bg-blue-100 border-blue-500">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Mostrar mensaje de error --}}
        @if (session('error'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
            >   
                <div class="max-w-lg mx-auto">
                    <div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                        <!-- Ícono SVG de error en rojo -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>                          
                        <div>
                            <span class="font-medium">¡Error!</span>
                            <p class="text-red-700 bg-red-100 border-red-500">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>            
            </div>
        @endif

        {{-- Botón de Agregar un Registro Nuevo --}}
        <div class="p-4 flex mt-4">
            <button 
                class="bg-amber-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-4 py-4 rounded cursor-pointer uppercase flex flex-col items-center"
                wire:click="openCreateModal()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM8.547 4.505a8.25 8.25 0 1 0 11.672 8.214l-.46-.46a2.252 2.252 0 0 1-.422-.586l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.211.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.654-.261a2.25 2.25 0 0 1-1.384-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.279-2.132Z" clip-rule="evenodd"/>
                </svg>
                Agregar un País
            </button>
        </div>         

        {{-- Botón de Buscar --}}
        <form wire:submit.prevent='leerDatosFormulario'>
            <div class="p-4 flex">
                <!-- Campo de búsqueda con etiqueta arriba -->
                <div class="flex flex-col w-full md:w-1/2">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar País</label>
                    <input 
                        id="termino"
                        type="text"
                        placeholder="Buscar país..."
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
                        <th class="px-4 py-2 text-center">País</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paises as $pais)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $pais->id_pais }}</td>
                            <td class="px-4 py-2 text-center">{{ $pais->descripcion }}</td>
                            <td class="px-4 py-2 text-center">

                                <button wire:click="openCreateModal({{ $pais->id_pais }})" id="edit-btn-{{ $pais->id_pais }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>                                      
                                </button>
                                <button wire:click="eliminarPais({{ $pais->id_pais }})" 
                                    onclick="confirm('¿Seguro de eliminar este país?') || event.stopImmediatePropagation()" id="delete-btn-{{ $pais->id_pais }}"
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
            {{ $paises->links('pagination::tailwind') }}
        </div>
    </div>

    {{-- Modal Nuevo Pais --}}
    @if ($modal)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
            <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
                <div class="w-full">
                    <div class="m-8 my-20 max-w-[400px] mx-auto">
                    <div class="mb-4">
                        <h1 class="font-extrabold">Agregar un País</h1>
                    </div>
                    <form action="">
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-bold text-gray-700">País</label>
                            <input autofocus wire:model="descripcion" type="text" id="descripcion" name="descripcion" 
                                    placeholder="Escriba un nuevo País"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                        </div>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </form>
                    
                    <div class="mb-4 flex flex-row gap-6">
                        <button 
                                class="p-3 bg-black rounded-full text-white w-full font-semibold" 
                                wire:click="createorUpdatePais">{{ isset($miPais->id_pais) ? 'Actualizar' : 'Crear' }} País</button>
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