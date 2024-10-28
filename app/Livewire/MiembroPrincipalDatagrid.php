<?php

namespace App\Livewire;

use App\Models\Pais;
use App\Models\User;
use Livewire\Component;
use App\Models\RedCercana;
use App\Models\EstadoCivil;
use Livewire\WithPagination;
use App\Models\EstadoLaboral;
use App\Models\EstadoMiembro;
use App\Models\Evento;
use App\Models\PermisoTrabajo;
use App\Models\MiembroPrincipal;
use App\Models\MiembroSecundario;
use App\Models\Parentesco;
use App\Models\PermisoResidencia;
use Illuminate\Database\QueryException;

class MiembroPrincipalDatagrid extends Component
{
    use WithPagination;
    
    public $termino = '';
    // Variables
    public $id_miembroprincipal;
    public $nombrecompleto;
    public $documento;
    public $telefono;
    public $correo;
    public $id_pais;
    public $fecha_registro;
    public $fecha_nacimiento;
    public $sexo;
    public $id_estadocivil;
    public $id_estadomi;
    public $miembros_hogar;
    public $hijos;
    public $hijos_menores;
    public $id_permisore;
    public $id_permisotra;
    public $id_estadola;
    public $id_red;
    public $codigointerno;
    public $inicio_asignacion;
    public $fin_asignacion;
    public $id_user;
    // Parametros
    public $miMiembroPrincipal = null;
    public $miMiembroSecundario = null;
    public $miEvento = null;
    public $modal = false;
    public $modalSegundo = false;
    public $modalAgenda = false;
    public $siActualiza = false;
    
    protected $rules = [
        'nombrecompleto' => 'required|min:3',
    ];

    public function leerDatosFormulario()
    {
        $this->dispatch('terminosBusqueda', $this->termino);
    }

    private function clearFields(){
        // Variables para Miembro Principal
        $this->id_miembroprincipal='';
        $this->nombrecompleto='';
        $this->documento='';
        $this->telefono='';
        $this->correo='';
        $this->id_pais=null;
        $this->fecha_registro=null;
        $this->fecha_nacimiento=null;
        $this->sexo='';
        $this->id_estadocivil=null;
        $this->id_estadomi=null;
        $this->miembros_hogar=0;
        $this->hijos=0;
        $this->hijos_menores=0;
        $this->id_permisore=null;
        $this->id_permisotra=null;
        $this->id_estadola=null;
        $this->id_red=null;
        $this->codigointerno='';
        $this->inicio_asignacion=null;
        $this->fin_asignacion=null;
        $this->id_user=null;
        
        // Parametros
        $this->miMiembroPrincipal = null;
        $this->miMiembroSecundario = null;
        $this->siActualiza = false;
    }

    public function updatedTermino()
    {
        $this->resetPage(); 
    }

    // Inicio de Controles de Modal para Miembros Principales
    public function openCreateModal($id_miembroprincipal = null){
        
        $this->siActualiza = false;

        if($id_miembroprincipal){
            // Datos de Miembros Principales 
            $this->miMiembroPrincipal = MiembroPrincipal::find($id_miembroprincipal);
            $this->id_miembroprincipal = $this->miMiembroPrincipal->id_miembroprincipal;
            $this->nombrecompleto = strtoupper($this->miMiembroPrincipal->nombrecompleto) ?? '';
            $this->documento = strtoupper($this->miMiembroPrincipal->documento) ?? '';
            $this->telefono = $this->miMiembroPrincipal->telefono ?? '';
            $this->correo = $this->miMiembroPrincipal->correo ?? '';
            $this->id_pais = $this->miMiembroPrincipal->id_pais ?? null;
            $this->fecha_registro= $this->miMiembroPrincipal->fecha_registro ?? null;
            $this->fecha_nacimiento= $this->miMiembroPrincipal->fecha_nacimiento ?? null;
            $this->sexo= $this->miMiembroPrincipal->sexo ?? null;
            $this->id_estadocivil= $this->miMiembroPrincipal->id_estadocivil ?? null;
            $this->id_estadomi= $this->miMiembroPrincipal->id_estadomi ?? null;
            $this->miembros_hogar= $this->miMiembroPrincipal->miembros_hogar ?? 0;
            $this->hijos= $this->miMiembroPrincipal->hijos ?? 0;
            $this->hijos_menores= $this->miMiembroPrincipal->hijos_menores ?? 0;
            $this->id_permisore= $this->miMiembroPrincipal->id_permisore ?? null;
            $this->id_permisotra= $this->miMiembroPrincipal->id_permisotra ?? null;
            $this->id_estadola= $this->miMiembroPrincipal->id_estadola ?? null;
            $this->id_red= $this->miMiembroPrincipal->id_red ?? null;
            $this->codigointerno= strtoupper($this->miMiembroPrincipal->codigointerno) ?? '';
            $this->inicio_asignacion= $this->miMiembroPrincipal->inicio_agignacion ?? null;
            $this->fin_asignacion= $this->miMiembroPrincipal->fin_asignacion ?? null;
            $this->id_user= $this->miMiembroPrincipal->id_user ?? null;
        }else{
                $this->clearFields();
        }
        $this->modal = true;
    }

    public function createorUpdateMiembroPrincipal(){
        
        $this->validate();

        try {

            if (is_null($this->miMiembroPrincipal)) {
                MiembroPrincipal::create([
                    'nombrecompleto' => strtoupper($this->nombrecompleto),
                    'documento' => strtoupper($this->documento),
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'id_pais' => $this->id_pais,
                    'fecha_registro' => $this->fecha_registro,
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'sexo' => $this->sexo,
                    'id_estadocivil' => $this->id_estadocivil,
                    'id_estadomi' => $this->id_estadomi,
                    'miembros_hogar' => $this->miembros_hogar,
                    'hijos' => $this->hijos,
                    'hijos_menores' => $this->hijos_menores,
                    'id_permisore' => $this->id_permisore,
                    'id_permisotra' => $this->id_permisotra,
                    'id_estadola' => $this->id_estadola,
                    'id_red' => $this->id_red,
                    'codigointerno' => strtoupper($this->codigointerno),
                    'inicio_asignacion' => $this->inicio_asignacion,
                    'fin_asignacion' => $this->fin_asignacion,
                    'id_user' => $this->id_user,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Miembro Principal creado exitosamente.');
            } else {
                $this->miMiembroPrincipal->update([
                    'nombrecompleto' => strtoupper($this->nombrecompleto),
                    'documento' => strtoupper($this->documento),
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'id_pais' => $this->id_pais,
                    'fecha_registro' => $this->fecha_registro,
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'sexo' => $this->sexo,
                    'id_estadocivil' => $this->id_estadocivil,
                    'id_estadomi' => $this->id_estadomi,
                    'miembros_hogar' => $this->miembros_hogar,
                    'hijos' => $this->hijos,
                    'hijos_menores' => $this->hijos_menores,
                    'id_permisore' => $this->id_permisore,
                    'id_permisotra' => $this->id_permisotra,
                    'id_estadola' => $this->id_estadola,
                    'id_red' => $this->id_red,
                    'codigointerno' => strtoupper($this->codigointerno),
                    'inicio_asignacion' => $this->inicio_asignacion,
                    'fin_asignacion' => $this->fin_asignacion,
                    'id_user' => $this->id_user,
                ]);

                // Mensaje de éxito
                session()->flash('success', 'Miembro Principal actualizado exitosamente.');
            }
    
            // Limpiamos los campos y cerramos el modal
            $this->clearFields();
            $this->modal = false;
        
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al guardar el Miembro Principal. Inténtalo nuevamente.');
        }

        return redirect()->route('miembrosprincipales.index'); 
    }

    public function eliminarMiembroPrincipal($id_miembroprincipal){

        try {
            
            MiembroPrincipal::findOrFail($id_miembroprincipal)->delete();
    
                return redirect()->back()->with('success', 'Miembro Principal se ha eliminado correctamente.');
            } catch (QueryException $e) {
    
                if ($e->getCode() == '23000') { // Código SQLSTATE para violación de clave foránea
                    return redirect()->back()->with('error', 'No se puede eliminar el Miembro Principal porque está relacionado con otros registros.');
                }
        
                return redirect()->back()->with('error', 'Ocurrió un error al intentar eliminar el Miembro Principal.');
            }
        
            return redirect()->route('miembrosprincipales.index'); 
    }

    // Inicio de Controles de Modal para Miembros Secundarios
    public function openSecundario($id_miembroprincipal = null)
    {    
        $this->siActualiza = false;

        if($id_miembroprincipal){
            
            $this->miMiembroSecundario = MiembroSecundario::where('id_miembroprincipal', $id_miembroprincipal)->get();

            if ($this->miMiembroSecundario->isEmpty()) {
                $this->miMiembroSecundario = collect(); // Colección vacía si no hay resultados
            }
        } else {
            $this->clearFields();
        }
    
        $this->modalSegundo = true; // Muestra el modal
    }

    // Inicio de Controles de Modal para Agenda
    public function openAgenda($id_miembroprincipal = null)
    {    
        $this->siActualiza = false; 

        if($id_miembroprincipal){
            
            $this->miEvento = Evento::where('id_miembroprincipal', $id_miembroprincipal)->get();

            if ($this->miEvento->isEmpty()) {
                $this->miEvento = collect(); // Colección vacía si no hay resultados
            }
        } else {
            $this->clearFields();
        }

        $this->modalAgenda = true; // Muestra el modal
    }
   
    public function closeCreateModal(){
        $this->clearFields();
        $this->resetValidation();
        $this->modal = false;
    }

    public function closeModalSegundo(){
        $this->clearFields();
        $this->resetValidation();
        $this->modalSegundo = false;
    }

    public function closeModalAgenda(){
        $this->clearFields();
        $this->resetValidation();
        $this->modalAgenda = false;
    }

    public function render()
    {   
        $paises = Pais::all();
        $estadosciviles = EstadoCivil::all();
        $estadosmiembros = EstadoMiembro::all();
        $permisosresidencias = PermisoResidencia::all();
        $permisostrabajos = PermisoTrabajo::all();
        $estadoslaborales = EstadoLaboral::all();
        $redescercanas = RedCercana::all();
        $usuarios = User::all();
        $parentescos = Parentesco::all();

        $termino = strtoupper($this->termino); // Convertir a mayúsculas
        $miembrosprincipales = MiembroPrincipal::where('nombrecompleto', 'like', '%' . $termino . '%')
        ->orWhere('documento', 'like', '%' . $termino . '%')
        ->orWhere('telefono', 'like', '%' . $termino . '%')
        ->orWhere('correo', 'like', '%' . $termino . '%')
        ->paginate(10);

        // Si quieres pasar los miembros secundarios en el render
        $miMiembroSecundario = collect(); // Colección vacía por defecto

        // Si hay un miembro principal seleccionado, puedes cargar sus miembros secundarios
        if ($this->id_miembroprincipal) {
            $miMiembroSecundario = MiembroSecundario::where('id_miembroprincipal', $this->id_miembroprincipal)->get();
        }

        $miEvento = collect();
        if ($this->id_miembroprincipal) {
            $miEvento = Evento::where('id_miembroprincipal', $this->id_miembroprincipal)->get();
        }


        return view('livewire.miembro-principal-datagrid', [
            'miembrosprincipales' => $miembrosprincipales,
            'paises' => $paises,
            'estadosciviles' => $estadosciviles,
            'estadosmiembros' => $estadosmiembros,
            'permisosresidencias' => $permisosresidencias,
            'permisostrabajos' => $permisostrabajos,
            'estadoslaborales' => $estadoslaborales,
            'redescercanas' => $redescercanas,
            'usuarios' => $usuarios,
            'parentescos' => $parentescos
        ]);
    }
}
