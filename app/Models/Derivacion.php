<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Derivacion extends Model
{
    use HasFactory;

    protected $table = 'derivaciones';
    protected $primaryKey = 'id_derivacion';
    
    protected $fillable = [
        'id_miembroprincipal',
        'id_entidad',
        'cantidad',
        'id_tipotarjeta',
    ];

    public function miembroprincipal()
    {
        return $this->belongsTo(MiembroPrincipal::class, 'id_miembroprincipal');
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'id_entidad');
    }

    public function tipotarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'id_tipotarjeta');
    }

}
