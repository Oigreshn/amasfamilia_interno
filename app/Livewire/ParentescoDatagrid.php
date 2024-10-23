<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Parentesco;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class ParentescoDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_parentesco;
    public $descripcion; 
    public $miParentesco = null;
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
        $this->id_parentesco ='';
        $this->descripcion='';
        $this->miParentesco = null;
        $this->siActualiza = false;
    }
    
    public function updatedTermino()
    {
        $this->resetPage();   
    }
    
    public function openCreateModal($id_parentesco = null){
        
        $this->siActualiza = false;

        if($id_parentesco){
            $this->miParentesco = Parentesco::find($id_parentesco);
            $this->descripcion = strtoupper($this->miParentesco->descripcion);
            $this->id_parentesco = $this->miParentesco->id_parentesco;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateParentesco()
    {
        $this->validate();

        try {
            if (is_null($this->miParentesco)) {
                Parentesco::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Parentesco creado exitosamente.');
            } else {
                $this->miParentesco->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Parentesco actualizado exitosamente.');
            }

            $this->clearFields();
            $this->modal = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Parentesco. Inténtalo nuevamente.');
        }

        return redirect()->route('parentesco.index');
    }

    public function eliminarParentesco($id_parentesco){
        
        try {
            
        Parentesco::findOrFail($id_parentesco)->delete();

            return redirect()->back()->with('success', 'El Parentesco se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar el Parentesco porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Parentesco.');
        }

        return redirect()->route('parentesco.index');
    }
    
    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $parentescos = Parentesco::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.parentesco-datagrid', [
            'parentescos' =>$parentescos,
        ]);
    }
}
