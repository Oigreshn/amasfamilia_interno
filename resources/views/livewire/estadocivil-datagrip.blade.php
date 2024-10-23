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
      <div class="p-4 flex mt-4">
          <button 
              class="bg-amber-500 hover:bg-indigo-600 transition-colors text-white text-sm font-bold px-4 py-4 rounded cursor-pointer uppercase flex flex-col items-center"
              wire:click="openCreateModal()"
          >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8 text-white">
                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
            </svg>
              Agregar Estado Civil
          </button>
      </div>         

    {{-- Botón de Buscar --}}
    <form wire:submit.prevent='leerDatosFormulario'>
        <div class="p-4 flex">
            <!-- Campo de búsqueda con etiqueta arriba -->
            <div class="flex flex-col w-full md:w-1/2">
                <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar Estado Civil</label>
                <input 
                    id="termino"
                    type="text"
                    placeholder="Buscar Estado Civil..."
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
                    <th class="px-4 py-2 text-center">Estado Civil</th>
                    <th class="px-4 py-2 text-center">Acciones</th>
                </tr>
              </thead>
              <tbody>
                  @foreach($estadosciviles as $estadocivil)
                      <tr class="border-t">
                          <td class="px-4 py-2 text-center">{{ $estadocivil->id_estadocivil }}</td>
                          <td class="px-4 py-2 text-center">{{ $estadocivil->descripcion }}</td>
                          <td class="px-4 py-2 text-center">

                              <button wire:click="openCreateModal({{ $estadocivil->id_estadocivil }})" id="edit-btn-{{ $estadocivil->id_estadocivil }}"
                                  class="bg-blue-500 text-white px-4 py-2 rounded w-full md:w-auto">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                  </svg>                                      
                              </button>
                              <button wire:click="eliminarEstadoCivil({{ $estadocivil->id_estadocivil }})" 
                                  onclick="confirm('¿Seguro de eliminar este Estado Civil?') || event.stopImmediatePropagation()" id="delete-btn-{{ $estadocivil->id_estadocivil }}"
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
          {{ $estadosciviles->links('pagination::tailwind') }}
      </div>
    </div>

    {{-- Modal Nuevo Estado Civil --}}
    @if ($modal)
          <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
          <div class="max-h-full w-full max-w-xl overflow-y-auto sm:rounded-2xl bg-white">
            <div class="w-full">
              <div class="m-8 my-20 max-w-[400px] mx-auto">
                <div class="mb-4">
                  <h1 class="font-extrabold">Agregar un Estado Civil</h1>
                </div>
                <form action="">
                    <div class="mb-4">
                      <label for="descripcion" class="block text-sm font-bold text-gray-700">Estado Civil</label>
                      <input autofocus wire:model="descripcion" type="text" id="descripcion" name="descripcion" 
                            placeholder="Escriba un nuevo Estado Civil"
                          class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500 uppercase" />
                    </div>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </form>
                
                <div class="flex flex-row gap-6">
                  <button 
                          class="p-3 bg-black rounded-full text-white w-full font-semibold" 
                          wire:click="createorUpdateEstadoCivil">{{ isset($miEstadocivil->id_estadocivil) ? 'Actualizar' : 'Crear' }} Estado Civil</button>
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