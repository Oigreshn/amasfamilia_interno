<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedCercana extends Model
{
    use HasFactory;

    protected $table = 'redescercanas';

    protected $primaryKey = 'id_red';

    protected $fillable = ['descripcion'];
}
