<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaProducto extends Model
{

    public $timestamps = false;
    protected $table = 'entregas_productos';

    protected $fillable = [
        'id',
        'id_usuario',
        'id_registro',
        'id_producto',
        'fecha_entrega',
        'status'
    ];

    protected $hiden = [];
}
