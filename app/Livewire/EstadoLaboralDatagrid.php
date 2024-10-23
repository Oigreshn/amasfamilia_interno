<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EstadoLaboral;
use Illuminate\Database\QueryException;

class EstadoLaboralDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_estadola;
    public $descripcion; 
    public $miEstadola = null;
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
        $this->id_estadola='';
        $this->descripcion='';
        $this->miEstadola = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

    public function openCreateModal($id_estadola = null){
        
        $this->siActualiza = false;

        if($id_estadola){
            $this->miEstadola = EstadoLaboral::find($id_estadola);
            $this->descripcion = strtoupper($this->miEstadola->descripcion);
            $this->id_estadola = $this->miEstadola->id_estadola;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateEstadoLaboral(){
        $this->validate();

        try {

            if (is_null($this->miEstadola)) {
                EstadoLaboral::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado Laboral creado exitosamente.');
            } else {
                $this->miEstadola->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Estado Laboral actualizado exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;

        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Estado Laboral. Inténtalo nuevamente.');
        }

        return redirect()->route('estadolaboral.index'); 
    }

    public function eliminarEstadoLaboral($id_estadola){

        try {
            
            EstadoLaboral::findOrFail($id_estadola)->delete();
    
                return redirect()->back()->with('success', 'El Estado Laboral se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar el Estado Laboral porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Estado Laboral.');
            }
        
        return redirect()->route('estadolaboral.index');
    }

    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $estadoslaborales = EstadoLaboral::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.estado-laboral-datagrid', [
            'estadoslaborales' => $estadoslaborales,
        ]); 
    }
}
