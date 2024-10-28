<?php

namespace App\Models;

use App\Models\User;
use App\Models\MiembroPrincipal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    
    protected $fillable = [
        'id_miembroprincipal',
        'tipo_apoyo',
        'estado_evento',
        'fecha',
        'hora',
        'descripcion',
        'id_user',
    ];

    public function miembroprincipal()
    {
        return $this->belongsTo(MiembroPrincipal::class, 'id_miembroprincipal');
    }
    
    public function usuarios()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
