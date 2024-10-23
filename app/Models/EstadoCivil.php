<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    use HasFactory;
    
    protected $table = 'estadocivil';

    protected $primaryKey = 'id_estadocivil';

    protected $fillable = ['descripcion'];
}
