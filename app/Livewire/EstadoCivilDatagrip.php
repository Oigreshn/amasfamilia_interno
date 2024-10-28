<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\EstadoCivil;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class EstadoCivilDatagrip extends Component
{
    use WithPagination; 
    
    public $termino = '';
    public $id_estadocivil;
    public $descripcion; 
    public $miEstadocivil = null;
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
        $this->id_estadocivil='';
        $this->descripcion='';
        $this->miEstadocivil = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

    public function openCreateModal($id_estadocivil = null){
        
        $this->siActualiza = false;

        if($id_estadocivil){
            $this->miEstadocivil = EstadoCivil::find($id_estadocivil);
            $this->descripcion = strtoupper($this->miEstadocivil->descripcion);
            $this->id_estadocivil = $this->miEstadocivil->id_estadocivil;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateEstadoCivil()
    {
        $this->validate();

        try {

            if (is_null($this->miEstadocivil)) {
                EstadoCivil::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado Civil creado exitosamente.');
            } else {
                $this->miEstadocivil->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado Civil actualizado exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Estado Civil. Inténtalo nuevamente.');
        }
    
        return redirect()->route('estadocivil.index'); 
     }

     public function eliminarEstadoCivil($id_estadocivil){
        
        try {
            
            EstadoCivil::findOrFail($id_estadocivil)->delete();
    
                return redirect()->back()->with('success', 'El Estado Civil se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar el Estado Civil porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Estado Civil.');
            }
        
        return redirect()->route('estadocivil.index');
    }

     public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {   
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $estadosciviles = EstadoCivil::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.estadocivil-datagrip', [
            'estadosciviles' => $estadosciviles,
        ]);
    }
}