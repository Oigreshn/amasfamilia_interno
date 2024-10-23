<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RedCercana;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class RedCercanaDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_red;
    public $descripcion; 
    public $miRed = null;
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
        $this->id_red ='';
        $this->descripcion='';
        $this->miRed = null;
        $this->siActualiza = false;
    }
 
    public function updatedTermino()
    {
        $this->resetPage();   
    }

    public function openCreateModal($id_red = null){
        
        $this->siActualiza = false;

        if($id_red){
            $this->miRed = RedCercana::find($id_red);
            $this->descripcion = strtoupper($this->miRed->descripcion);
            $this->id_red = $this->miRed->id_red;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateRedCercana()
    {
        $this->validate();

        try {
            if (is_null($this->miRed)) {
                RedCercana::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Red Cercana creada exitosamente.');
            } else {
                $this->miRed->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Red Cercana actualizada exitosamente.');
            }

            $this->clearFields();
            $this->modal = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar la Red Cercana. Inténtalo nuevamente.');
        }

        return redirect()->route('redcercana.index');
    }

    public function eliminarRedCercana($id_red){
        
        try {
            
        RedCercana::findOrFail($id_red)->delete();

            return redirect()->back()->with('success', 'La Red Cercana se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar la Red Cercana porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar la Red Cercana.');
        }

        return redirect()->route('redcercana.index');
    }
    
    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }
    
    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $redescercanas = RedCercana::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.red-cercana-datagrid', [
            'redescercanas' => $redescercanas,
        ]);
    }
}
