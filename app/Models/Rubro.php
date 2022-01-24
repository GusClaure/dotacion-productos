<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'nombre_rubro',
        'descripcion'
    ];

    protected $hiden = ['fecha_registro'];
    
}
