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
        <div class="p-4 flex mt-4"">
            <button 
                class="bg-amber-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-4 py-4 rounded cursor-pointer uppercase flex flex-col items-center"
                wire:click="openCreateModal()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                    <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                </svg>           
            Agregar Nuevo Miembro Secundario
            </button>
        </div>

        {{-- Formulario de búsqueda --}}
        <form wire:submit.prevent='leerDatosFormulario'>
            <div class="p-4 flex">
                <!-- Campo de búsqueda con etiqueta arriba -->
                <div class="flex flex-col w-full md:w-1/2">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar un Miembro Secundario</label>
                    <input 
                        id="termino"
                        type="text"
                        placeholder="Buscar por: Nombre, Documento"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring 
                        focus:ring-indigo-200 focus:ring-opacity-50 px-3 py-1 uppercase"
                        wire:model="termino"
                    />
                </div>
            </div>            
        </form>
        {{-- Fin de Formulario de búsqueda --}} 

        <!-- Tabla centrada y mejorada -->
        <div class="py-4 overflow-x-auto shadow-lg rounded-lg">
            <table class="min-w-full table-auto bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-center">ID</th>
                        <th class="px-4 py-2 text-center">Nombre Completo</th>
                        <th class="px-4 py-2 text-center">Fecha Nacimiento</th>
                        <th class="px-4 py-2 text-center">Documento</th>
                        <th class="px-4 py-2 text-center text-amber-500 underline font-extrabold">Miembro Principal</th>
                        <th class="px-4 py-2 text-center">Parentesco</th>
                        <th class="px-4 py-2 text-center"># Teléfono</th>
                        <th class="px-4 py-2 text-center">Correo Electrónico</th>
                        <th class="px-4 py-2 text-center">Codigo Interno</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($miembrossecundarios as $miembrosecundario)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->id_miembrosecundario }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->nombrecompleto }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->fecha_nacimiento }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->documento }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $miembrosecundario->miembroprincipal->nombrecompleto ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $miembrosecundario->parentesco->descripcion ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->telefono }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->correo }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembrosecundario->codigointerno }}</td>
                            <td class="px-4 py-2 text-center">
                                <button wire:click="openCreateModal({{ $miembrosecundario->id_miembrosecundario }})" id="edit-btn-{{ $miembrosecundario->id_miembrosecundario }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>                                      
                                </button>
                                <button wire:click="eliminarMiembroSecundario({{ $miembrosecundario->id_miembrosecundario }})" 
                                    onclick="confirm('¿Seguro de eliminar este Miembro Secundario?') || event.stopImmediatePropagation()" id="delete-btn-{{ $miembrosecundario->id_miembrosecundario }}"
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
            {{ $miembrossecundarios->links('pagination::tailwind') }} 
        </div>
    </div>

{{-- Modal Nuevo Miembro Secundario --}}
@if ($modal)
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-6xl overflow-y-auto sm:rounded-2xl bg-white p-8">
            <div class="w-full">
                <div class="mb-4 text-center">
                    <h1 class="font-extrabold text-2xl">Agregar un Miembro Secundario</h1>
                </div>

                {{-- Formulario --}}
                <form wire:submit.prevent="guardarMiembroSecundario">
                    {{-- Campo de búsqueda de Miembro Principal --}}
                    @if(!$siActualiza) {{-- Mostrar solo si no estamos en modo edición --}}
                        <div class="mb-4">
                            <x-input-label for="miembro_principal" class="block text-sm font-bold text-gray-700" :value="__('Buscar Miembro Principal')"/>
                            <div class="flex">
                                <input 
                                    id="miembro_principal"
                                    type="text"
                                    placeholder="Buscar por Nombre, Documento, Teléfono o Correo"
                                    class="w-full border-gray-300 rounded-l-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase"
                                    wire:model="termino"
                                />
                                <button 
                                    type="button"
                                    wire:click="filtrarMiembroPrincipal"
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700 focus:outline-none focus:ring">
                                    Filtrar
                                </button>
                            </div>

                            {{-- Lista desplegable de resultados --}}
                            @if($miembrosPrincipales)
                                <ul class="bg-white border rounded shadow mt-2 max-h-48 overflow-auto">
                                    @foreach($miembrosPrincipales as $miembro)
                                        <li class="p-2 hover:bg-indigo-100 cursor-pointer" wire:click="seleccionarMiembroPrincipal({{ $miembro->id_miembroprincipal }})">
                                            {{ $miembro->nombrecompleto }} | {{ $miembro->documento }} | {{ $miembro->telefono }} | {{ $miembro->estadomiembro->descripcion }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <x-input-error :messages="$errors->get('id_miembroprincipal')" class="mt-2" />
                        </div>
                    @endif

                   {{-- Apartado para mostrar información del miembro principal seleccionado --}}
                   @if($miembroSeleccionado)
                        <div class="mb-4 p-4 bg-gray-100 rounded-lg shadow-md">
                            <h2 class="text-lg text-center font-bold underline text-amber-500">Miembro Principal Seleccionado:</h2>
                            <p class="text-gray-700 text-sm"><strong>Nombre:</strong> {{ $miembroSeleccionado->nombrecompleto }}</p>
                            <p class="text-gray-700 text-sm"><strong>Documento:</strong> {{ $miembroSeleccionado->documento }}</p>
                            <p class="text-gray-700 text-sm"><strong>Teléfono:</strong> {{ $miembroSeleccionado->telefono }}</p>
                            <p class="text-gray-700 text-sm"><strong>Correo Electrónico:</strong> {{ $miembroSeleccionado->correo }}</p>
                            <p class="text-gray-700 text-sm"><strong>Estado de Miembro:</strong> {{ $miembroSeleccionado->estadomiembro->descripcion }}</p>
                        </div>
                    @endif


                    {{-- Primera fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="nombrecompleto" class="block text-sm font-bold text-gray-700" :value="__('Nombre Completo')"/>
                            <x-text-input wire:model="nombrecompleto" type="text" id="nombrecompleto" name="nombrecompleto"
                                placeholder="Nombre Completo"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('nombrecompleto')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="fecha_nacimiento" class="block text-sm font-bold text-gray-700" :value="__('Fecha de Nacimiento')"/>
                            <x-text-input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="documento" class="block text-sm font-bold text-gray-700" :value="__('Documento')"/>
                            <x-text-input wire:model="documento" type="text" id="documento" name="documento"
                                placeholder="DNI/NIE/Pasaporte"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('documento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_parentesco" class="block text-sm font-bold text-gray-700" :value="__('Parentesco')"/>
                            <select wire:model="id_parentesco" id="id_parentesco" name="id_parentesco"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Parentesco</option>
                                @foreach ($parentescos as $parentesco)
                                    <option value="{{ $parentesco->id_parentesco }}">{{ $parentesco->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_parentesco')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Segunda fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="telefono" class="block text-sm font-bold text-gray-700" :value="__('Teléfono')"/>
                            <x-text-input wire:model="telefono" type="text" id="telefono" name="telefono"
                                placeholder="Teléfono"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="correo" class="block text-sm font-bold text-gray-700" :value="__('Correo Electrónico')"/>
                            <x-text-input wire:model="correo" type="email" id="correo" name="correo"
                                placeholder="Correo Electrónico"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="codigointerno" class="block text-sm font-bold text-gray-700" :value="__('Codigo A+Familias')"/>
                            <x-text-input wire:model="codigointerno" type="text" id="codigointerno" name="codigointerno"
                                placeholder="Codigo A+Familias"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('codigointerno')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="id_user" class="block text-sm font-bold text-gray-700" :value="__('TS')"/>
                            <select wire:model="id_user" id="id_user" name="id_user"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un TS</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id')" class="mt-2" />
                        </div>
                        
                    </div>
                </form>

                {{-- Botones de acción --}}
                <div class="py-4 mb-4 flex flex-row gap-6">
                    <button 
                            class="p-3 bg-black rounded-full text-white w-full font-semibold" 
                            wire:click="createorUpdateMiembroSecundario">{{ isset($miMiembroSecundario->id_miembrosecundario) ? 'Actualizar' : 'Crear' }} Miembro Secundario</button>
                    </button>
                    <button 
                            class="p-3 bg-white border rounded-full w-full font-semibold"  
                            wire:click.prevent="closeCreateModal">Salir</button>
                </div>
            </div>
        </div>
    </div>
@endif
</div> 
