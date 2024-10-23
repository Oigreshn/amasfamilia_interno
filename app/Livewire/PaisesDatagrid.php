<?php

namespace App\Livewire;

use App\Models\Pais;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class PaisesDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    public $id_pais;
    public $descripcion; 
    public $miPais = null;
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
        $this->id_pais='';
        $this->descripcion='';
        $this->miPais = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage();  
    }

    public function openCreateModal($id_pais = null){
        
        $this->siActualiza = false;

        if($id_pais){
            $this->miPais = Pais::find($id_pais);
            $this->descripcion = strtoupper($this->miPais->descripcion);
            $this->id_pais = $this->miPais->id_pais;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdatePais()
    {
        $this->validate();

        try {

            if (is_null($this->miPais)) {
                Pais::create([
                    'descripcion' => strtoupper($this->descripcion),
                ]);
                // Mensaje de éxito
                session()->flash('success', 'País creado exitosamente.');
            } else {
                $this->miPais->update([
                    'descripcion' => strtoupper($this->descripcion),
                ]);

                 // Mensaje de éxito
                 session()->flash('success', 'País actualizado exitosamente.');
            }

            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el País. Inténtalo nuevamente.');
        }

        return redirect()->route('paises.index');
    }

    public function eliminarPais($id_pais)
    {
        try {
            
            Pais::findOrFail($id_pais)->delete();

            return redirect()->back()->with('success', 'El País se ha eliminado correctamente.');
        } catch (QueryException $e) {

            if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                return redirect()->back()->with('error', 'No se puede eliminar el País porque está relacionado con otros registros.');
            }
    
            return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el País.');
        }
        
        return redirect()->route('paises.index');
    }

    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function render()
    {
        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $paises = Pais::where('descripcion', 'like', '%' . $termino . '%')->paginate(10);

        return view('livewire.paises-datagrid', [
            'paises' => $paises,
        ]);
    }
}
