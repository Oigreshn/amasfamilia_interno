<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoTrabajo extends Model
{
    use HasFactory;

    protected $table = 'permisotrabajo';

    protected $primaryKey = 'id_permisotra';

    protected $fillable = ['descripcion'];
}
