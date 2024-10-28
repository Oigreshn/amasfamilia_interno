<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Parentesco;
use Livewire\WithPagination;
use App\Models\MiembroPrincipal;
use App\Models\MiembroSecundario;
use Illuminate\Database\QueryException;

class MiembroSecundarioDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_miembrosecundario;
    public $nombrecompleto = '';
    public $fecha_nacimiento;
    public $documento;
    public $id_parentesco;
    public $telefono;
    public $correo;
    public $codigointerno;
    public $id_user;

    public $miMiembroSecundario = null;
    public $modal = false;
    public $siActualiza = false;

    //Para controlar los Miembros Principales
    public $miembrosPrincipales = [];
    public $id_miembroprincipal;
    public $miembroSeleccionado = null;

    protected $rules = [
        'nombrecompleto' => 'required|min:3',
    ];

    public function leerDatosFormulario()
    {
        $this->dispatch('terminosBusqueda', $this->termino); 
    }

    private function clearFields(){
        $this->id_miembrosecundario='';
        $this->nombrecompleto='';
        $this->fecha_nacimiento=null;
        $this->documento='';
        $this->id_parentesco=null;
        $this->telefono='';
        $this->correo='';
        $this->codigointerno='';
        $this->id_user=null;

        $this->miMiembroSecundario = null;
        $this->siActualiza = false;
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

   
    public function openCreateModal($id_miembrosecundario = null){
        
        if($id_miembrosecundario){
            $this->siActualiza = true;
            $this->miMiembroSecundario = MiembroSecundario::find($id_miembrosecundario);
            $this->id_miembrosecundario = $this->miMiembroSecundario->id_miembrosecundario;
            $this->nombrecompleto = strtoupper($this->miMiembroSecundario->nombrecompleto);
            $this->fecha_nacimiento = $this->miMiembroSecundario->fecha_nacimiento;
            $this->documento = strtoupper($this->miMiembroSecundario->documento);
            $this->id_miembroprincipal = $this->miMiembroSecundario->id_miembroprincipal ?? null;
            $this->id_parentesco = $this->miMiembroSecundario->id_parentesco ?? null;
            $this->telefono = $this->miMiembroSecundario->telefono ?? '';
            $this->correo = $this->miMiembroSecundario->correo ?? '';
            $this->codigointerno= strtoupper($this->miMiembroSecundario->codigointerno) ?? '';
            $this->id_user= $this->miMiembroSecundario->id_user ?? null;

             // Si el miembro secundario está asociado a un miembro principal
             if ($this->miMiembroSecundario->miembroPrincipal) {
                $this->seleccionarMiembroPrincipal($this->miMiembroSecundario->miembroPrincipal->id_miembroprincipal);
            }
        } else {
            $this->siActualiza = false;
            $this->clearFields();
            $this->miembroSeleccionado = null;
        }
    
        $this->modal = true;
    }

    public function createorUpdateMiembroSecundario()
    {
        $this->validate();

        try {

            if (is_null($this->miMiembroSecundario)) {
                MiembroSecundario::create([
                    'id_miembrosecundario' => $this->id_miembrosecundario,
                    'nombrecompleto' => strtoupper($this->nombrecompleto),
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'documento' => strtoupper($this->documento),
                    'id_miembroprincipal' => $this->id_miembroprincipal,
                    'id_parentesco' => $this->id_parentesco,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'codigointerno' => strtoupper($this->codigointerno),
                    'id_user' => $this->id_user,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Miembro Secundario creado exitosamente.');
            } else {
                $this->miMiembroSecundario->update([
                    'id_miembrosecundario' => $this->id_miembrosecundario,
                    'nombrecompleto' => strtoupper($this->nombrecompleto),
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'documento' => strtoupper($this->documento),
                    'id_miembroprincipal' => $this->id_miembroprincipal,
                    'id_parentesco' => $this->id_parentesco,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'codigointerno' => strtoupper($this->codigointerno),
                    'id_user' => $this->id_user,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Miembro Secundario actualizado exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Miembro Secundario. Inténtalo nuevamente.');
        }

        return redirect()->route('miembrosecundario.index'); 
    }

    public function eliminarMiembroSecundario($id_miembrosecundario){

        try {
            
            MiembroSecundario::findOrFail($id_miembrosecundario)->delete();
    
                return redirect()->back()->with('success', 'Miembro Secundario se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar el Miembro Secundario porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Miembro Secundario.');
            }
        
            return redirect()->route('miembrosecundario.index'); 
    }


    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $parentescos = Parentesco::all();
        $usuarios = User::all();

        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $miembrossecundarios = MiembroSecundario::where('nombrecompleto', 'like', '%' . $termino . '%')
        ->orWhere('documento', 'like', '%' . $termino . '%')
        ->paginate(10);

        return view('livewire.miembro-secundario-datagrid', [
            'miembrossecundarios' => $miembrossecundarios,
            'parentescos' => $parentescos,
            'usuarios' => $usuarios,
        ]);
    }
}
