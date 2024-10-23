<div class="bg-gray-100 border rounded-lg border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto">

        {{-- Mensajes de éxito o error --}}
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
                class="mt-2 text-indigo-500"
            >
                <div class="flex items-center">
                    <!-- Ícono SVG de éxito -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-10.707a1 1 0 10-1.414-1.414L9 9.586 7.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>

                    <!-- Título -->
                    <h4 class="font-bold">¡Éxito!</h4>
                </div>
                <x-input-error :messages="session('success')" class="mt-1" />
            </div>
        @endif

        @if (session('error'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)" 
                class="mt-2 text-red-500"
            >
                <div class="flex items-center">
                    <!-- Ícono SVG de error -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>                      
                    <!-- Título -->
                    <h4 class="font-bold">¡Error!</h4>
                </div>
                <x-input-error :messages="session('error')" class="mt-1" />
            </div>
        @endif 

        {{-- Botón de Agregar un Registro Nuevo --}}
        <div class="p-4 flex mt-4"">
            <button 
                class="bg-amber-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-4 py-4 rounded cursor-pointer uppercase flex flex-col items-center"
                wire:click="openCreateModal()"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                </svg>     
            Agregar Nuevo Miembro Principal
            </button>
        </div>

        {{-- Formulario de búsqueda --}}
        <form wire:submit.prevent='leerDatosFormulario'>
            <div class="p-4 flex">
                <!-- Campo de búsqueda con etiqueta arriba -->
                <div class="flex flex-col w-full md:w-1/2">
                    <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar un Miembro Principal</label>
                    <input 
                        id="termino"
                        type="text"
                        placeholder="Buscar por: Nombre, Documento, Telefono y Correo electrónico"
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
                        <th class="px-4 py-2 text-center">Documento</th>
                        <th class="px-4 py-2 text-center"># Teléfono</th>
                        <th class="px-4 py-2 text-center">Correo Electrónico</th>
                        <th class="px-4 py-2 text-center">Estado de Miembro</th>
                        <th class="px-4 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($miembrosprincipales as $miembroprincipal)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $miembroprincipal->id_miembroprincipal }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembroprincipal->nombrecompleto }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembroprincipal->documento }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembroprincipal->telefono }}</td>
                            <td class="px-4 py-2 text-center">{{ $miembroprincipal->correo }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ $miembroprincipal->estadomiembro->descripcion ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <button wire:click="openCreateModal({{ $miembroprincipal->id_miembroprincipal }})" id="edit-btn-{{ $miembroprincipal->id_miembroprincipal }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>                                      
                                </button>
                                <button wire:click="openSecundario({{ $miembroprincipal->id_miembroprincipal }})" id="view-btn-{{ $miembroprincipal->id_miembroprincipal }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z" clip-rule="evenodd" />
                                        <path d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
                                    </svg>                              
                                </button>
                                <button wire:click="eliminarMiembroPrincipal({{ $miembroprincipal->id_miembroprincipal }})" 
                                    onclick="confirm('¿Seguro de eliminar este Miembro Principal?') || event.stopImmediatePropagation()" id="delete-btn-{{ $miembroprincipal->id_miembroprincipal }}"
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
            {{ $miembrosprincipales->links('pagination::tailwind') }}
        </div>
    </div>

{{-- Modal Nuevo Miembro --}} 
@if ($modal)
    <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-6xl overflow-y-auto sm:rounded-2xl bg-white p-8">
            <div class="w-full">
                <div class="mb-4 text-center">
                    <h1 class="font-extrabold text-2xl">Agregar un Miembro Principal</h1>
                </div>

                {{-- Formulario --}}
                <form  action="">
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
                            <x-input-label for="documento" class="block text-sm font-bold text-gray-700" :value="__('Documento')"/>
                            <x-text-input wire:model="documento" type="text" id="documento" name="documento"
                                placeholder="DNI/NIE/Pasaporte"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('documento')" class="mt-2" />
                        </div>

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
                    </div>

                    {{-- Segunda fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4">
                        <div>
                            <x-input-label for="id_pais" class="block text-sm font-bold text-gray-700" :value="__('País')"/>
                            <select wire:model="id_pais" id="id_pais" name="id_pais"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un País</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id_pais }}">{{ $pais->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_pais')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fecha_registro" class="block text-sm font-bold text-gray-700" :value="__('Fecha de Registro')"/>
                            <x-text-input wire:model="fecha_registro" type="date" id="fecha_registro" name="fecha_registro"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('fecha_registro')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fecha_nacimiento" class="block text-sm font-bold text-gray-700" :value="__('Fecha de Nacimiento')"/>
                            <x-text-input wire:model="fecha_nacimiento" type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sexo" class="block text-sm font-bold text-gray-700" :value="__('Sexo')"/>
                            <select wire:model="sexo" id="sexo" name="sexo"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione..</option>
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMENINO">FEMENINO</option>
                                    <option value="FEMENINO">OTRO</option>
                                    <option value="FEMENINO">NO ESPECIFICADO</option>
                            </select>
                            <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Tercera fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4">                         
                        <div>
                            <x-input-label for="id_estadocivil" class="block text-sm font-bold text-gray-700" :value="__('Estado Civil')"/>
                            <select wire:model="id_estadocivil" id="id_estadocivil" name="id_estadocivil"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Estado Civil</option>
                                @foreach ($estadosciviles as $estadocivil)
                                    <option value="{{ $estadocivil->id_estadocivil }}">{{ $estadocivil->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_estadocivil')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_estadomi" class="block text-sm font-bold text-gray-700" :value="__('Estado de Miembro')"/>
                            <select wire:model="id_estadomi" id="id_estadomi" name="id_estadomi"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Estado de Miembro</option>
                                @foreach ($estadosmiembros as $estadomiembro)
                                    <option value="{{ $estadomiembro->id_estadomi }}">{{ $estadomiembro->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_estadomi')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="miembros_hogar" class="block text-sm font-bold text-gray-700" :value="__('# Miembros en Hogar')"/>
                            <x-text-input wire:model="miembros_hogar" type="number" id="miembros_hogar" name="miembros_hogar"
                                placeholder="Número de Miembros"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                min="1" step="1" />
                            <x-input-error :messages="$errors->get('miembros_hogar')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="hijos" class="block text-sm font-bold text-gray-700" :value="__('# Hijos')"/>
                            <x-text-input wire:model="hijos" type="number" id="hijos" name="hijos"
                                placeholder="Número de Hijos"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                min="1" step="1" />
                            <x-input-error :messages="$errors->get('hijos')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Cuarta fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4"> 
                        <div>
                            <x-input-label for="hijos_menores" class="block text-sm font-bold text-gray-700" :value="__('# Hijos Menores')"/>
                            <x-text-input wire:model="hijos_menores" type="number" id="hijos_menores" name="hijos_menores"
                                placeholder="Número de Hijos Menores"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                min="1" step="1" />
                            <x-input-error :messages="$errors->get('hijos_menores')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_permisore" class="block text-sm font-bold text-gray-700" :value="__('Permiso Residencia')"/>
                            <select wire:model="id_permisore" id="id_permisore" name="id_permisore"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Permiso de Residencia</option>
                                @foreach ($permisosresidencias as $permisoresidencia)
                                    <option value="{{ $permisoresidencia->id_permisore }}">{{ $permisoresidencia->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_permisore')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_permisotra" class="block text-sm font-bold text-gray-700" :value="__('Permiso de Trabajo')"/>
                            <select wire:model="id_permisotra" id="id_permisotra" name="id_permisotra"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Permiso de Trabajo</option>
                                @foreach ($permisostrabajos as $permisotrabajo)
                                    <option value="{{ $permisotrabajo->id_permisotra }}">{{ $permisotrabajo->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_permisotra')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_estadola" class="block text-sm font-bold text-gray-700" :value="__('Estado Laboral')"/>
                            <select wire:model="id_estadola" id="id_estadola" name="id_estadola"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione un Estado Laboral</option>
                                @foreach ($estadoslaborales as $estadolaboral)
                                    <option value="{{ $estadolaboral->id_estadola }}">{{ $estadolaboral->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_estadola')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Quinta fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4"> 
                        <div>
                            <x-input-label for="id_red" class="block text-sm font-bold text-gray-700" :value="__('Red Cercana')"/>
                            <select wire:model="id_red" id="id_red" name="id_red"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Seleccione una Red Cercana</option>
                                @foreach ($redescercanas as $redcercana)
                                    <option value="{{ $redcercana->id_red }}">{{ $redcercana->descripcion }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_red')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="codigointerno" class="block text-sm font-bold text-gray-700" :value="__('Codigo A+Familias')"/>
                            <x-text-input wire:model="codigointerno" type="text" id="codigointerno" name="codigointerno"
                                placeholder="Codigo A+Familias"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                            <x-input-error :messages="$errors->get('codigointerno')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="inicio_asignacion" class="block text-sm font-bold text-gray-700" :value="__('Inicio de Asignación')"/>
                            <input wire:model="inicio_asignacion" type="date" id="inicio_asignacion" name="inicio_asignacion"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('inicio_asignacion')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="fin_asignacion" class="block text-sm font-bold text-gray-700" :value="__('Fin de Asignación')"/>
                            <input wire:model="fin_asignacion" type="date" id="fin_asignacion" name="fin_asignacion"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            <x-input-error :messages="$errors->get('fin_asignacion')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Sexta fila: 4 campos --}}
                    <div class="mb-4 grid grid-cols-4 gap-4"> 
                       
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
                            wire:click="createorUpdateMiembroPrincipal">{{ isset($miMiembroPrincipal->id_miembroprincipal) ? 'Actualizar' : 'Crear' }} Miembro Principal</button>
                    </button>
                    <button 
                            class="p-3 bg-white border rounded-full w-full font-semibold" 
                            wire:click.prevent="closeCreateModal">Salir</button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Modal Miembros Secundarios --}}
@if ($modalSegundo)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 py-10">
        <div class="max-h-full w-full max-w-6xl overflow-y-auto sm:rounded-2xl bg-white p-8 shadow-lg">
            <div class="w-full">
                <div class="mb-4 text-center">
                    <h1 class="font-extrabold text-2xl">Miembros Secundarios</h1>
                </div>

                <!-- Verificar si hay miembros secundarios -->
                @if ($miMiembroSecundario->isEmpty())
                    <div class="py-4 text-center text-gray-500">
                        <p class="text-lg">No hay miembros secundarios registrados actualmente.</p>
                    </div>
                @else
                    <!-- Tabla centrada y mejorada -->
                    <div class="py-4 overflow-x-auto shadow-md rounded-lg">
                        <table class="min-w-full table-auto bg-white border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-center px-4 py-2">ID</th>
                                    <th class="text-center px-4 py-2">Nombre Completo</th>
                                    <th class="text-center px-4 py-2">Fecha Nacimiento</th>
                                    <th class="text-center px-4 py-2">Documento</th>
                                    <th class="text-center px-4 py-2">Parentesco</th>
                                    <th class="text-center px-4 py-2">Teléfono</th>
                                    <th class="text-center px-4 py-2">Correo Electrónico</th>
                                    <th class="text-center px-4 py-2">Código Interno</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($miMiembroSecundario as $miembrosecundario)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->id_miembrosecundario }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->nombrecompleto }}</td>
                                        <td class="text-center px-4 py-2">{{ \Carbon\Carbon::parse($miembrosecundario->fecha_nacimiento)->format('d/m/Y') }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->documento }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->parentesco->descripcion }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->telefono }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->correo }}</td>
                                        <td class="text-center px-4 py-2">{{ $miembrosecundario->codigointerno }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Botón de salida -->
                <div class="py-4 flex justify-end">
                    <button 
                        class="px-4 py-2 bg-gray-800 text-white rounded-full font-semibold hover:bg-gray-700"
                        wire:click.prevent="closeModalSegundo">
                        Salir
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>
