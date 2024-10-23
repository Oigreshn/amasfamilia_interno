<?php

namespace App\Livewire;

use App\Models\Pais;
use App\Models\Entidad;
use Livewire\Component;
use App\Models\RedCercana;
use App\Models\EstadoCivil;
use App\Models\EstadoLaboral;
use App\Models\EstadoMiembro;
use App\Models\Parentesco;
use App\Models\PermisoTrabajo;
use App\Models\PermisoResidencia;
use App\Models\TipoTarjeta;

class Dashboard extends Component
{

    public $totalPaises;
    public $totalEstadosCiviles;
    public $totalEstadosMiembros;
    public $totalEntidades;
    public $totalEstadosLaborales;
    public $totalPermisosresidencia;
    public $totalPermisostrabajo;
    public $totalRedescercanas;
    public $totalTiposTarjetas;
    public $totalParentescos;

    public function mount()
    {
        // Contar el total de registros en las tablas
        $this->totalPaises = Pais::count();
        $this->totalEstadosCiviles = EstadoCivil::count();
        $this->totalEstadosMiembros = EstadoMiembro::count();
        $this->totalEntidades = Entidad::count();
        $this->totalEstadosLaborales = EstadoLaboral::count();
        $this->totalPermisosresidencia = PermisoResidencia::count();
        $this->totalPermisostrabajo = PermisoTrabajo::count();
        $this->totalRedescercanas = RedCercana::count();
        $this->totalTiposTarjetas = TipoTarjeta::count();
        $this->totalParentescos = Parentesco::count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
