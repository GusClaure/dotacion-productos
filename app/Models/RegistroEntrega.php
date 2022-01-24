<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroEntrega extends Model
{

    public $timestamps = false;
    
    protected $table = 'registros_entregas';

    protected $fillable = [
        'id',
        'id_persona',
        'observacion',
        'fecha_registro',
        'status'
    ];

    protected $hiden = [];
}
