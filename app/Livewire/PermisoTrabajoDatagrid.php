<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PermisoTrabajo;
use Illuminate\Database\QueryException;

class PermisoTrabajoDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_permisotra;
    public $descripcion; 
    public $miPermisotra = null;
    public $modal = false;
    public $siActualiza = false;

    protected $rules = [
        'descripcion' => 'required|min:3',
    ];

    public function leerDatosFormulario()
    {
        $this->dispatch('terminosBusqueda', $this->termino);
    }

    private function clearFields(){
        $this->id_permisotra ='';
        $this->descripcion='';
        $this->miPermisotra = null;
        $this->siActualiza = false;
    }
 
    public function updatedTermino()
    {
        $this->resetPage();  
    }

    public function openCreateModal($id_permisotra = null){
        
        $this->siActualiza = false;

        if($id_permisotra){
            $this->miPermisotra = PermisoTrabajo::find($id_permisotra);
            $this->descripcion = strtoupper($this->miPermisotra->descripcion);
            $this->id_permisotra = $this->miPermisotra->id_permisotra;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdatePermisoTrabajo()
    {
        $this->validate();

        try {
            if (is_null($this->miPermisotra)) {
                PermisoTrabajo::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Permiso de Trabajo creado exitosamente.');
            } else {
                $this->miPermisotra->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Permiso de Trabajo actualizado exitosamente.');
            }

            $this->clearFields();
            $this->modal = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Permiso de Trabajo. Inténtalo nuevamente.');
        }

        return redirect()->route('permisotrabajo.index');
    }

    public function eliminarPermisoTrabajo($id_permisotra){
        
        try {
            
        PermisoTrabajo::findOrFail($id_permisotra)->delete();

            return redirect()->back()->with('success', 'El Permiso de Trabajo se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar el Permiso de Trabajo porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Permiso de Trabajo.');
        }

        return redirect()->route('permisotrabajo.index');
    }

    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $permisostrabajos = PermisoTrabajo::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.permiso-trabajo-datagrid', [
            'permisostrabajos' => $permisostrabajos,
        ]);
    }
}
