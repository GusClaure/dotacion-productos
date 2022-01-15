<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


    public static function getAllCountData(){

        $data = DB::select("select
           count(1) as total,
           count(1) filter (where status = :status_entregado) as total_entregados,
           count(1) filter (where status = 'PENDIENTE') as total_pendientes,
           count(1) filter (where status = 'OBSERVADO') as total_observados,
           count(1) filter (where sindicato = 'Maica Sud' and status = 'ENTREGADO') as Maica_Sud,
           count(1) filter (where sindicato = 'Maica Chica' and status = 'ENTREGADO') as Maica_Chica,
           count(1) filter (where sindicato = 'Maica Arriba' and status = 'ENTREGADO') as Maica_Arriba,
           count(1) filter (where sindicato = 'Maica central' and status = 'ENTREGADO') as Maica_central,
           count(1) filter (where sindicato = 'Maica Norte' and status = 'ENTREGADO') as Maica_Norte,
           count(1) filter (where sindicato = 'Maica Milenario' and status = 'ENTREGADO') as Maica_Milenario,
           count(1) filter (where sindicato = 'Maica Kaspichaca' and status = 'ENTREGADO') as Maica_Kaspichaca,
           count(1) filter (where sindicato = 'Maica San Isidro' and status = 'ENTREGADO') as Maica_San_Isidro,
           count(1) filter (where sindicato = 'Maica Quenamari' and status = 'ENTREGADO') as Maica_Quenamari,
           count(1) filter (where sindicato = 'Maica Bolivia' and status = 'ENTREGADO') as Maica_Bolivia
         from personas", 
                    [
                        'status_entregado' => 'ENTREGADO',
                    ]
                    );
        return $data[0];
    }
}
