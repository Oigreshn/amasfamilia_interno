<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoTarjeta;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class TipoTarjetaDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_tipotarjeta;
    public $descripcion; 
    public $miTipoTarjeta = null;
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
        $this->id_tipotarjeta ='';
        $this->descripcion='';
        $this->miTipoTarjeta = null;
        $this->siActualiza = false;
    }
    
    public function updatedTermino()
    {
        $this->resetPage();   
    }
    
    public function openCreateModal($id_tipotarjeta = null){
        
        $this->siActualiza = false;

        if($id_tipotarjeta){
            $this->miTipoTarjeta = TipoTarjeta::find($id_tipotarjeta);
            $this->descripcion = strtoupper($this->miTipoTarjeta->descripcion);
            $this->id_tipotarjeta = $this->miTipoTarjeta->id_tipotarjeta;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateTipoTarjeta()
    {
        $this->validate();

        try {
            if (is_null($this->miTipoTarjeta)) {
                TipoTarjeta::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Tipo de Tarjeta creado exitosamente.');
            } else {
                $this->miTipoTarjeta->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Tipo de Tarjeta actualizado exitosamente.');
            }

            $this->clearFields();
            $this->modal = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Tipo de Tarjeta. Inténtalo nuevamente.');
        }

        return redirect()->route('tipotarjetas.index');
    }

    public function eliminarTipoTarjeta($id_tipotarjeta){
        
        try {
            
        TipoTarjeta::findOrFail($id_tipotarjeta)->delete();

            return redirect()->back()->with('success', 'El Tipo de Tarjeta se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar el Tipo de Tarjeta porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Tipo de Tarjeta.');
        }

        return redirect()->route('tipotarjetas.index');
    }
    
    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $tipostarjetas = TipoTarjeta::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.tipo-tarjeta-datagrid', [
            'tipostarjetas' => $tipostarjetas,
        ]);
    }
}
