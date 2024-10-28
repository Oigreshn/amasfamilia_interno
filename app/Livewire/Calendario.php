<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Evento;
use Livewire\Component;
use App\Models\MiembroPrincipal;

class Calendario extends Component
{
    public $termino = '';
    public $mesActual;
    public $anioActual;
    public $diasDelMes;
    public $diasEnBlanco;
    public $eventosPorDia = [];
    public $modal = false;
    public $siActualiza = false;
    public $fechaSeleccionada;

    // Para datos de Evento
    public $id_evento;
    public $tipo_apoyo = '';
    public $estado_evento = '';
    public $fecha;
    public $hora;
    public $descripcion;
    public $id_user;
    public $miEvento;

    //Para controlar los Miembros Principales
    public $miembrosPrincipales = [];
    public $id_miembroprincipal;
    public $miembroSeleccionado = null;

    private function clearFields(){
        $this->id_miembroprincipal='';
        $this->tipo_apoyo='';
        $this->estado_evento='';
        $this->fecha=null;
        $this->hora=null;
        $this->descripcion='';
        $this->id_user=null;

        $this->miEvento = null;
        $this->siActualiza = false;
    }

    protected $rules = [
        'id_miembroprincipal' => 'required|integer|exists:miembrosprincipales,id_miembroprincipal',
        'tipo_apoyo' => 'required|in:APOYO JURIDICO,APOYO LABORAL,APOYO SALUD,APOYO ECONOMICO,GENERAL',
        'fecha' => 'required|date',
        'hora' => 'required|date_format:H:i',
    ];

    public function filtrarMiembroPrincipal()
    {
        $this->miembrosPrincipales = MiembroPrincipal::where('nombrecompleto', 'like', '%' . $this->termino . '%')
        ->orWhere('documento', 'like', '%' . $this->termino . '%')
        ->orWhere('telefono', 'like', '%' . $this->termino . '%')
        ->orWhere('correo', 'like', '%' . $this->termino . '%')
        ->get();
    }

    public function seleccionarMiembroPrincipal($id_miembroprincipal)
    {
        $this->id_miembroprincipal = $id_miembroprincipal;
        $this->miembroSeleccionado = MiembroPrincipal::find($id_miembroprincipal); // Cargar los datos del miembro seleccionado
        $this->miembrosPrincipales = []; // Limpiar resultados después de la selección
    }

    public function mount()
    {
        $this->mesActual = now()->month;
        $this->anioActual = now()->year;
        $this->cargarEventosDelMes();
        $this->calcularCalendario();
    }

    public function calcularCalendario()
    {
        $fecha = Carbon::create($this->anioActual, $this->mesActual, 1);
        $this->diasDelMes = $fecha->daysInMonth;

        // Calcula días en blanco para alinear el calendario
        $this->diasEnBlanco = $fecha->startOfMonth()->dayOfWeek;
    }

    public function mesAnterior()
    {
        if ($this->mesActual == 1) {
            $this->mesActual = 12;
            $this->anioActual--;
        } else {
            $this->mesActual--;
        }
        $this->cargarEventosDelMes();
        $this->calcularCalendario();
    }
 
    public function mesSiguiente()
    {
        if ($this->mesActual == 12) { 
            $this->mesActual = 1;
            $this->anioActual++;
        } else {
            $this->mesActual++;
        }
        $this->cargarEventosDelMes();
        $this->calcularCalendario();
    }

    public function abrirModal($dia)
    {
        $carbonFecha = Carbon::create($this->anioActual, $this->mesActual, $dia);
        $this->fechaSeleccionada = $carbonFecha->locale('es')->translatedFormat('j \d\e F \d\e\l Y');

        $this->fecha = $carbonFecha->format('Y-m-d');
        
        $this->modal = true;
    }

    public function createorUpdateEvento()
    {
        $this->validate();
        
        try {
            
            if (is_null($this->miEvento)) {
                $this->estado_evento = $this->estado_evento ?: 'PROGRAMADA';
                Evento::create([
                    'id_evento' => $this->id_evento,
                    'id_miembroprincipal' => $this->id_miembroprincipal,
                    'tipo_apoyo' => strtoupper($this->tipo_apoyo),
                    'estado_evento' => strtoupper($this->estado_evento),
                    'fecha' => $this->fecha,
                    'hora' => $this->hora,
                    'id_user' => $this->id_user,
                ]);

                 // Mensaje de éxito
                 session()->flash('success', 'Evento creado exitosamente.');
            } else {
                $this->miEvento->update([
                    'id_evento' => $this->id_evento,
                    'id_miembroprincipal' => $this->id_miembroprincipal,
                    'tipo_apoyo' => strtoupper($this->tipo_apoyo),
                    'estado_evento' => strtoupper($this->estado_evento),
                    'fecha' => $this->fecha,
                    'hora' => $this->hora,
                    'descripcion' => $this->descripcion,
                    'id_user' => $this->id_user,
                ]);
    
                // Mensaje de éxito
                session()->flash('success', 'Evento actualizado exitosamente.');
            }
               
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Evento. Inténtalo nuevamente.');
        }

        return redirect()->route('eventos.index'); 
    }

    public function mostrarDetallesEvento($eventoId)
    {
       //Extracción de Datos
       if($eventoId){
            $this->siActualiza = true;
            $this->miEvento = Evento::find($eventoId);
            $this->id_evento = $this->miEvento->id_evento;
            $this->id_miembroprincipal = $this->miEvento->id_miembroprincipal;
            $this->tipo_apoyo = $this->miEvento->tipo_apoyo;
            $this->estado_evento = $this->miEvento->estado_evento;
            $this->fecha = $this->miEvento->fecha;
            $this->hora = Carbon::parse($this->miEvento->hora)->format('H:i');
            $this->descripcion = $this->miEvento->descripcion;
            $this->id_user = $this->miEvento->id_user;
            // Si el miembro secundario está asociado a un miembro principal
            if ($this->miEvento->miembroPrincipal) {
                $this->seleccionarMiembroPrincipal($this->miEvento->miembroPrincipal->id_miembroprincipal);
            }
        } else {
            $this->siActualiza = false;
            $this->clearFields();
            $this->miembroSeleccionado = null;
        }

    $this->modal = true; 
    //Fin de Extracción de Datos
    }

    public function cargarEventosDelMes()
    {
        $eventos = Evento::with('miembroprincipal')
                    ->whereYear('fecha', $this->anioActual)
                    ->whereMonth('fecha', $this->mesActual)
                    ->where('estado_evento', 'PROGRAMADA')
                    ->orderBy('fecha')
                    ->orderBy('hora')
                    ->get();
  
        $this->eventosPorDia = $eventos->groupBy(function ($evento) {
              return Carbon::parse($evento->fecha)->format('Y-m-d');
              })->map(function ($eventos) {
              return $eventos->map(function ($evento) {
                    return [
                        'id_evento' => $evento->id_evento,
                        'hora' => Carbon::parse($evento->hora)->format('H:i'),
                        'tipo_apoyo' => $evento->tipo_apoyo,
                        'estado_evento' => $evento->estado_evento,
                        'miembro_nombre' => $evento->miembroprincipal ? $evento->miembroprincipal->nombrecompleto : 'Miembro no asignado',
                    ];
                })->toArray();
           })->toArray();
    }
    
    public function cerrarModal()
    {
        $this->modal = false;
        $this->fechaSeleccionada = null;
        $this->clearFields();
        $this->miembroSeleccionado = null;
    }

    public function render()
    {
        $usuarios = User::all();
        
        return view('livewire.calendario', [
            'nombreMes' => Carbon::create($this->anioActual, $this->mesActual)->locale('es')->monthName,
            'anio' => $this->anioActual,
            'usuarios' => $usuarios,
            'eventosPorDia' => $this->eventosPorDia,  
        ]);
    }
}