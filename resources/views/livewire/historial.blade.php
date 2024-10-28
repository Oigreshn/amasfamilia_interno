<div class="bg-gray-100 border rounded-lg border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto">
  
      {{-- Botón de Buscar --}}
      <form wire:submit.prevent='leerDatosFormulario'>
          <div class="p-4 flex">
              <!-- Campo de búsqueda con etiqueta arriba -->
              <div class="flex flex-col w-full md:w-1/2">
                  <label class="block mb-1 text-sm text-gray-700 uppercase font-bold" for="termino">Buscar</label>
                  <input 
                      id="termino"
                      type="text"
                      placeholder="Buscar por: Nombre"
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
            <!-- Verificar si hay miembros secundarios -->
            @if ($eventos->isEmpty())
                <div class="py-4 text-center text-gray-500">
                    <p class="text-lg">No hay Eventos registrados actualmente.</p>
                </div>
            @else
                <!-- Tabla centrada y mejorada -->
                <div class="py-4 overflow-x-auto shadow-md rounded-lg">
                    <table class="min-w-full table-auto bg-white border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-center px-4 py-2">ID</th>
                                <th class="text-center px-4 py-2">Miembro Principal</th>
                                <th class="text-center px-4 py-2">Tipo de Apoyo</th>
                                <th class="text-center px-4 py-2">Notas de la Reunión</th>
                                <th class="text-center px-4 py-2">Estado Evento</th>
                                <th class="text-center px-4 py-2">Fecha</th>
                                <th class="text-center px-4 py-2">Hora</th>
                                <th class="text-center px-4 py-2">Atendido Por</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="text-center px-4 py-2">{{ $evento->id_evento }}</td>
                                    <td class="text-center px-4 py-2">{{ $evento->miembroprincipal->nombrecompleto }}</td>
                                    <td class="text-center px-4 py-2">{{ $evento->tipo_apoyo }}</td>
                                    <td class="text-center px-4 py-2">
                                        <div x-data="{ showDescription: false }">
                                            <button 
                                                @click="showDescription = !showDescription"
                                                class="text-blue-500 hover:underline">
                                                <span x-text="showDescription ? 'Ocultar' : 'Mostrar'"></span> Notas
                                            </button>
                                            
                                            <p x-show="showDescription" x-cloak class="mt-1 text-gray-600">
                                                {{ $evento->descripcion }}
                                            </p>
                                        </div>
                                    </td>
                            
                                    <td class="text-center px-4 py-2">
                                        <span class="
                                            px-2 py-1 rounded-full text-white font-semibold
                                            {{ $evento->estado_evento == 'PROGRAMADA' ? 'bg-blue-500' : '' }}
                                            {{ $evento->estado_evento == 'REALIZADA' ? 'bg-green-500' : '' }}
                                            {{ $evento->estado_evento == 'SUSPENDIDA' ? 'bg-red-500' : '' }}
                                            {{ !in_array($evento->estado_evento, ['PROGRAMADA', 'REALIZADA', 'SUSPENDIDA']) ? 'bg-gray-400' : '' }}">
                                            {{ $evento->estado_evento }}
                                        </span>
                                    </td>
                                    <td class="text-center px-4 py-2">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                                    <td class="text-center px-4 py-2">{{ \Carbon\Carbon::parse($evento->hora)->format('H:i') }}</td>
                                    <td class="text-center px-4 py-2">{{ $evento->usuarios->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    
        <!-- Paginación centrada -->
        <div class="my-10">
            {{ $eventos->links('pagination::tailwind') }}
        </div>
      </div>
  </div>