<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiembroSecundario extends Model
{
    use HasFactory;

    protected $table = 'miembrossecundarios';
    protected $primaryKey = 'id_miembrosecundario';
    
    protected $fillable = [
        'nombrecompleto',
        'fecha_nacimiento',
        'documento',
        'id_miembroprincipal',
        'id_parentesco',
        'telefono',
        'correo',
        'codigointerno',
        'id_user',
    ];

    public function miembroprincipal()
    {
        return $this->belongsTo(MiembroPrincipal::class, 'id_miembroprincipal');
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class, 'id_parentesco');
    }
}
 