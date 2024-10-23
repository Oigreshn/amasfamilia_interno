<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EstadoMiembro;
use Illuminate\Database\QueryException;

class EstadoMiembros extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_estadomi;
    public $descripcion; 
    public $miEstadomiembro = null;
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
        $this->id_estadomi='';
        $this->descripcion='';
        $this->miEstadomiembro = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

    public function openCreateModal($id_estadomi = null){
        
        $this->siActualiza = false;

        if($id_estadomi){
            $this->miEstadomiembro = EstadoMiembro::find($id_estadomi);
            $this->descripcion = strtoupper($this->miEstadomiembro->descripcion);
            $this->id_estadomi = $this->miEstadomiembro->id_estadomi;
        }else{
                $this->clearFields(); 
        }
        $this->modal = true;
    }

    public function createorUpdateEstadoMiembros(){
        
        $this->validate();

        try {

            if (is_null($this->miEstadomiembro)) {
                EstadoMiembro::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado de Miembros creado exitosamente.');
            } else {
                $this->miEstadomiembro->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado de Miembros actualizado exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Estado de Miembros. Inténtalo nuevamente.');
        }

        return redirect()->route('estadomiembros.index'); 
    }

    public function eliminarEstadoMiembros($id_estadomi){

        try {
            
            EstadoMiembro::findOrFail($id_estadomi)->delete();
    
                return redirect()->back()->with('success', 'El Estado de Miembro se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar el Estado de Miembro porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Estado de Miembro.');
            }
        
        return redirect()->route('estadomiembros.index');
    }

     public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $estadosmiembros = EstadoMiembro::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.estado-miembros', [
            'estadosmiembros' => $estadosmiembros,
        ]);
    }
}
