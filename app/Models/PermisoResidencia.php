<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoResidencia extends Model
{
    use HasFactory;

    protected $table = 'permisoresidencia';

    protected $primaryKey = 'id_permisore';

    protected $fillable = ['descripcion'];
}
