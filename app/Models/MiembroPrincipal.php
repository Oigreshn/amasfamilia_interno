<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembroPrincipal extends Model
{
    use HasFactory;

    protected $table = 'miembrosprincipales';
    protected $primaryKey = 'id_miembroprincipal';
    
    protected $fillable = [
        'nombrecompleto',
        'documento',
        'telefono',
        'correo',
        'id_pais',
        'fecha_registro',
        'fecha_nacimiento',
        'sexo',
        'id_estadocivil',
        'id_estadomi',
        'miembros_hogar',
        'hijos',
        'hijos_menores',
        'id_permisore',
        'id_permisotra',
        'id_estadola',
        'id_red',
        'codigointerno',
        'inicio_asignacion',
        'fin_asignacion',
        'id_user',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'id_entidad');
    }

    public function estadocivil()
    {
        return $this->belongsTo(EstadoCivil::class, 'id_estadocivil');
    }

    public function estadolaboral()
    {
        return $this->belongsTo(EstadoLaboral::class, 'id_estadola');
    }

    public function estadomiembro()
    {
        return $this->belongsTo(EstadoMiembro::class, 'id_estadomi');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais');
    }

    public function permisoresidencia()
    {
        return $this->belongsTo(PermisoTrabajo::class, 'id_permisore');
    }

    public function permisotrabajo()
    {
        return $this->belongsTo(PermisoTrabajo::class, 'id_permisotra');
    }

    public function redcercana()
    {
        return $this->belongsTo(RedCercana::class, 'id_red');
    }

    public function usuarios()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
