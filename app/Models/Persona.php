<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

    public $timestamps = false;
  
    protected $fillable = [
        'id',
        'nro_formulario',
        'nro_cel',
        'nombre',
        'primer_ap',
        'segundo_ap',
        'ci',
        'expedido',
        'distrito',
        'sub_central',
        'sindicato',
        'ubicacion',
        'fecha_registro',
        'usuario_id',
        'fecha_entrega',
        'categoria_id',
        'tipo',
        'producto',
        'observacion',
        'status'
    ];


    protected $hiden = [];
}
