<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoLaboral extends Model
{
    use HasFactory;

    protected $table = 'estadoslaborales';

    protected $primaryKey = 'id_estadola';

    protected $fillable = ['descripcion'];
}
