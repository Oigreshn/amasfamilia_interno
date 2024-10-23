<?php

namespace App\Livewire;

use App\Models\Entidad;
use Livewire\Component;
use App\Models\Derivacion;
use App\Models\TipoTarjeta;
use Livewire\WithPagination;
use App\Models\MiembroPrincipal;
use App\Models\User;
use Illuminate\Database\QueryException;

class DerivacionDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_derivacion;
    public $id_miembroprincipal;
    public $id_entidad;
    public $cantidad;
    public $id_tipotarjeta;

    public $miDerivacion = null;
    public $modal = false;
    public $siActualiza = false;

    //Para controlar los Miembros Principales
    public $miembrosPrincipales = [];
    public $miembroSeleccionado = null;

    protected $rules = [
        'cantidad' => 'required',
    ];

    public function leerDatosFormulario()
    {
        $this->dispatch('terminosBusqueda', $this->termino);
    }

    private function clearFields(){
        $this->id_miembroprincipal=null;
        $this->id_entidad=null;
        $this->cantidad=0;
        $this->id_tipotarjeta=null;

        $this->miDerivacion = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

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

    public function openCreateModal($id_derivacion = null){
        
        if($id_derivacion){
            $this->siActualiza = true;
            $this->miDerivacion = Derivacion::find($id_derivacion);
            $this->id_derivacion = $this->miDerivacion->id_derivacion;
            $this->id_miembroprincipal = $this->miDerivacion->id_miembroprincipal;
            $this->id_entidad = $this->miDerivacion->id_entidad;
            $this->cantidad = $this->miDerivacion->cantidad;
            $this->id_tipotarjeta = $this->miDerivacion->id_tipotarjeta;

            // Si el miembro secundario está asociado a un miembro principal
            if ($this->miDerivacion->miembroPrincipal) {
                $this->seleccionarMiembroPrincipal($this->miDerivacion->miembroPrincipal->id_miembroprincipal);
            }
        } else {
            $this->siActualiza = false;
            $this->clearFields();
            $this->miembroSeleccionado = null;
    }

    $this->modal = true;
    }

    public function createorUpdateDerivacion()
    {
        $this->validate();

        try {

            if (is_null($this->miDerivacion)) {
                Derivacion::create([
                    'id_derivacion' => $this->id_derivacion,
                    'id_miembroprincipal' => $this->id_miembroprincipal,
                    'id_entidad' => $this->id_entidad,
                    'cantidad' => $this->cantidad,
                    'id_tipotarjeta' => $this->id_tipotarjeta,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Derivación creada exitosamente.');
            } else {
                $this->miDerivacion->update([
                    'id_derivacion' => $this->id_derivacion,
                    'id_entidad' => $this->id_entidad,
                    'cantidad' => $this->cantidad,
                    'id_tipotarjeta' => $this->id_tipotarjeta,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Derivación actualizada exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar la Derivación. Inténtalo nuevamente.');
        }

        return redirect()->route('derivaciones.index'); 
    }

    public function eliminarDerivacion($id_derivacion){

        try {
            
            Derivacion::findOrFail($id_derivacion)->delete();
    
                return redirect()->back()->with('success', 'Derivación se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar la Derivación porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar la Derivación.');
            }
        
            return redirect()->route('derivaciones.index'); 
    }

    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $miembrosprincipales = MiembroPrincipal::all();
        $entidades = Entidad::all();
        $tipostarjetas = TipoTarjeta::all();
        $usuarios = User::all();

        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $derivaciones = Derivacion::where('id_miembroprincipal', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.derivacion-datagrid', [
            'derivaciones' => $derivaciones,
            'miembrosprincipales' => $miembrosprincipales,
            'entidades' => $entidades,
            'tipostarjetas' => $tipostarjetas, 
            'usuarios' => $usuarios,
        ]);
    }
}
