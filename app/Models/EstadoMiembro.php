<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoMiembro extends Model
{
    use HasFactory;

    protected $table = 'estadomiembros';

    protected $primaryKey = 'id_estadomi';

    protected $fillable = ['descripcion'];
}
