<div class="bg-white rounded-xl shadow-lg p-4 max-w-7xl mx-auto">
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

        <!-- Barra de navegación del calendario -->
        <div class="flex items-center justify-between px-6 py-4 bg-gray-200 rounded-t-lg">
            <button wire:click="mesAnterior" class="text-gray-600 hover:bg-gray-300 px-3 py-1 rounded">Anterior</button>
            <h2 class="text-xl text-gray-800 capitalize font-semibold">{{ $nombreMes }} {{ $anio }}</h2>
            <button wire:click="mesSiguiente" class="text-gray-600 hover:bg-gray-300 px-3 py-1 rounded">Siguiente</button>
        </div>        

        <!-- Encabezado de días de la semana -->
        <div class="grid grid-cols-7 gap-2 p-4 text-center text-gray-600 font-medium bg-gray-100 rounded-lg">
            <div>Dom</div><div>Lun</div><div>Mar</div><div>Mié</div><div>Jue</div><div>Vie</div><div>Sáb</div>
        </div>        

       <!-- Celdas del calendario -->
        <div class="grid grid-cols-7 gap-1 p-4" id="calendario">
            @for ($i = 0; $i < $diasEnBlanco; $i++)
                <div class="border bg-gray-50 h-16"></div>
            @endfor

            @foreach (range(1, $diasDelMes) as $dia)
                <button 
                        wire:click="abrirModal({{ $dia }})" 
                        id="ver-dia-{{ $dia }}-{{ $mesActual }}-{{ $anioActual }}"
                        class="top w-full text-center h-24 md:h-32 lg:h-40 border p-2 rounded-lg 
                            {{ now()->day == $dia && now()->month == $mesActual && now()->year == $anioActual 
                                ? 'bg-blue-500 rounded-lg' 
                                : 'bg-white hover:bg-blue-50' }}"
                    >
                        <!-- Número de día -->
                        <span class="block font-bold">{{ $dia }}</span>
                    
                        <!-- Listado de eventos en este día -->
                        @php
                            $fecha = \Carbon\Carbon::create($anioActual, $mesActual, $dia)->format('Y-m-d');
                            $eventos = $eventosPorDia[$fecha] ?? [];
                        @endphp
                    
                        @if (!empty($eventos))
                            <!-- Contenedor de eventos con scroll si hay muchos -->
                            <div class="event rounded text-sm overflow-y-auto max-h-24 mt-2 py-1 space-y-1">
                                @foreach ($eventos as $evento)
                                    @php
                                        // Establecer estilo de color de borde y sombra según el estado del evento
                                        $estadoColor = match ($evento['estado_evento']) {
                                            'PROGRAMADA' => 'border-indigo-500 shadow-indigo-100',
                                            'SUSPENDIDA' => 'border-red-500 shadow-red-100',
                                            'REALIZADA' => 'border-amber-500 shadow-amber-100',
                                            default => 'border-gray-300 shadow-gray-100',
                                        };
                                    @endphp
                    
                                    <!-- Evento -->
                                    <div 
                                        wire:click="mostrarDetallesEvento({{ $evento['id_evento'] }})"
                                        class="p-3 mt-2 text-sm bg-white border-l-4 rounded-lg shadow-md cursor-pointer {{ $estadoColor }}"
                                    >
                                        <p class="font-semibold truncate">{{ $evento['miembro_nombre'] ?? 'Miembro no asignado' }}</p>
                                        <p class="text-gray-600 text-sm">{{ $evento['hora'] }}</p>
                                        <p class="text-gray-500 text-sm">{{ $evento['tipo_apoyo'] ?? 'Tipo de apoyo no especificado' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </button>
            @endforeach
        </div>
    </div>


    @if($modal)
        <div class="fixed left-0 top-0 flex h-full w-full items-center justify-center bg-black bg-opacity-50 py-10">
            <div class="max-h-full w-full max-w-6xl overflow-y-auto sm:rounded-2xl bg-white p-8">
                <div class="w-full">
                    <div class="mb-4 text-center">
                        <h1 class="font-extrabold text-2xl">Reunión en: {{ $fechaSeleccionada }}</h1> 
                    </div>

                    {{-- Formulario --}}
                    <form wire:submit.prevent="guardarEventos">
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

                        {{-- Información del miembro principal seleccionado --}}
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
                                <x-input-label for="hora" :value="__('Hora de Reunión')" class="block text-sm font-bold text-gray-700"/>
                                <input wire:model="hora" type="time" id="hora" name="hora"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <x-input-error :messages="$errors->get('hora')" class="mt-2"/>
                            </div>
                            
                            <div>
                                <x-input-label for="tipo_apoyo" class="block text-sm font-bold text-gray-700" :value="__('Tipo de Apoyo')"/>
                                <select wire:model="tipo_apoyo" id="tipo_apoyo" name="tipo_apoyo"
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar..</option>
                                        <option value="APOYO JURIDICO">APOYO JURIDICO</option>
                                        <option value="APOYO LABORAL">APOYO LABORAL</option>
                                        <option value="APOYO SALUD">APOYO SALUD</option>
                                        <option value="APOYO ECONOMICO">APOYO ECONOMICO</option>
                                        <option value="GENERAL">GENERAL</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo_apoyo')" class="mt-2" />
                            </div>
                            
                            @if($siActualiza)
                                <div>
                                    <x-input-label for="estado_evento" class="block text-sm font-bold text-gray-700" :value="__('Estado de Reunión')"/>
                                    <select wire:model="estado_evento" id="estado_evento" name="estado_evento"
                                        class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Seleccione un Estado</option>
                                            <option value="PROGRAMADA">PROGRAMADA</option>
                                            <option value="SUSPENDIDA">SUSPENDIDA</option>
                                            <option value="REALIZADA">REALIZADA</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('estado_evento')" class="mt-2" />
                                </div>
                            @endif

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

                        {{-- Descripción solo en modo edición --}}
                        @if($siActualiza)
                            <div class="mb-4">
                                <x-input-label for="descripcion" :value="__('Notas de la Reunión')" class="block text-sm font-bold text-gray-700"/>
                                <textarea 
                                    wire:model="descripcion" 
                                    id="descripcion" 
                                    name="descripcion" 
                                    rows="4" 
                                    class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Agregue una descripción detallada sobre la reunión"
                                ></textarea>
                                <x-input-error :messages="$errors->get('descripcion')" class="mt-2"/>
                            </div>
                        @endif
                    </form>

                    {{-- Botones de acción --}} 
                    <div class="flex flex-row gap-6 mt-4">
                        <button 
                            class="p-3 bg-black rounded-full text-white w-full font-semibold" 
                            wire:click="createorUpdateEvento">{{ isset($miEvento->id_evento) ? 'Actualizar' : 'Crear' }} Evento</button> 
                        </button>
                        
                        <button 
                            class="p-3 bg-white border rounded-full w-full font-semibold"
                            wire:click="cerrarModal">
                            Salir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>