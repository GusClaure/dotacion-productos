<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'nombre_productos',
        'cantidad',
        'unidad'
    ];

    protected $hiden = ['fecha_registro'];
}
