<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroEntrega extends Model
{

    public $timestamps = false;
    
    protected $table = 'registros_entregas';

    protected $fillable = [
        'id',
        'id_usuario',
        'id_persona',
        'observacion',
        'fecha_entrega',
        'status'
    ];

    protected $hiden = [];
}
