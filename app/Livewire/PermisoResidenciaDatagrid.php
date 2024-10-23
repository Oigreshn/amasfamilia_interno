<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PermisoResidencia;
use Illuminate\Database\QueryException;

class PermisoResidenciaDatagrid extends Component
{   
    use WithPagination;
    
    public $termino = '';
    public $id_permisore;
    public $descripcion; 
    public $miPermisore = null;
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
        $this->id_permisore ='';
        $this->descripcion='';
        $this->miPermisore = null;
        $this->siActualiza = false;
    }
 
    public function updatedTermino()
    {
        $this->resetPage();  
    }

    public function openCreateModal($id_permisore = null){
        
        $this->siActualiza = false;

        if($id_permisore){
            $this->miPermisore = PermisoResidencia::find($id_permisore);
            $this->descripcion = strtoupper($this->miPermisore->descripcion);
            $this->id_permisore = $this->miPermisore->id_permisore;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdatePermisoResidencia()
    {
        $this->validate();

        try {
            if (is_null($this->miPermisore)) {
                PermisoResidencia::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Permiso de Residencia creado exitosamente.');
            } else {
                $this->miPermisore->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Permiso de Residencia actualizado exitosamente.');
            }

            $this->clearFields();
            $this->modal = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Permiso de Residencia. Inténtalo nuevamente.');
        }

        return redirect()->route('permisoresidencia.index');
    }

    public function eliminarPermisoResidencia($id_permisore){
        
        try {
            
        PermisoResidencia::findOrFail($id_permisore)->delete();

            return redirect()->back()->with('success', 'El Permiso de Residencia se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar el Permiso de Residencia porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Permiso de Residencia.');
        }

        return redirect()->route('permisoresidencia.index');
    }

    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    { 
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $permisosresidencia = PermisoResidencia::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.permiso-residencia-datagrid', [
            'permisosresidencia' => $permisosresidencia,
        ]);
    }
}
