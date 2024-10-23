<?php

namespace App\Livewire;

use App\Models\Entidad;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class EntidadesDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_entidad;
    public $descripcion; 
    public $miEntidad = null;
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
        $this->id_entidad='';
        $this->descripcion='';
        $this->miEntidad = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

    public function openCreateModal($id_entidad = null){
        
        $this->siActualiza = false;

        if($id_entidad){
            $this->miEntidad = Entidad::find($id_entidad);
            $this->descripcion = strtoupper($this->miEntidad->descripcion);
            $this->id_entidad = $this->miEntidad->id_entidad;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateEntidad(){
        $this->validate();

        try {
            if (is_null($this->miEntidad)) {
                Entidad::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);
                // Mensaje de éxito
                session()->flash('success', 'Entidad creada exitosamente.');
            } else {
                $this->miEntidad->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);
                // Mensaje de éxito
                session()->flash('success', 'Entidad actualizada exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar la Entidad. Inténtalo nuevamente.');
        }
    
        return redirect()->route('entidades.index'); 
    } 

    public function eliminarEntidad($id_entidad){

        try {
            Entidad::findOrFail($id_entidad)->delete();
            
            return redirect()->back()->with('success', 'La entidad se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar la Entidad porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar la Entidad.');
        }

        return redirect()->route('entidades.index');
    }

     public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }
    
    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $entidades = Entidad::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.entidades-datagrid', [
            'entidades' => $entidades,
        ]);
    }
}
