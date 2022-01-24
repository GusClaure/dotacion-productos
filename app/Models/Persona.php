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
        'rubro_id',
        'tipo',
        'fecha_registro',
        'status'
    ];

    

    protected $hiden = [];


    public static function getAllCountData(){

        
        $data = DB::select("select
        count(1) as total,
        count(1) filter (where registros_entregas.status = :status_entregado) as total_entregados,
        count(1) filter (where registros_entregas.status is null) as total_pendientes,
        count(1) filter (where registros_entregas.status = 'PENDIENTE-PRODUCTO') as total_pendientes_producto,
        count(1) filter (where registros_entregas.status = 'OBSERVADO') as total_observados,
        count(1) filter (where sindicato = 'Maica Sud' and registros_entregas.status = 'ENTREGADO') as Maica_Sud,
        count(1) filter (where sindicato = 'Maica Chica' and registros_entregas.status = 'ENTREGADO') as Maica_Chica,
        count(1) filter (where sindicato = 'Maica Arriba' and registros_entregas.status = 'ENTREGADO') as Maica_Arriba,
        count(1) filter (where sindicato = 'Maica central' and registros_entregas.status = 'ENTREGADO') as Maica_central,
        count(1) filter (where sindicato = 'Maica Norte' and registros_entregas.status = 'ENTREGADO') as Maica_Norte,
        count(1) filter (where sindicato = 'Maica Milenario' and registros_entregas.status = 'ENTREGADO') as Maica_Milenario,
        count(1) filter (where sindicato = 'Maica Kaspichaca' and registros_entregas.status = 'ENTREGADO') as Maica_Kaspichaca,
        count(1) filter (where sindicato = 'Maica San Isidro' and registros_entregas.status = 'ENTREGADO') as Maica_San_Isidro,
        count(1) filter (where sindicato = 'Maica Quenamari' and registros_entregas.status = 'ENTREGADO') as Maica_Quenamari,
        count(1) filter (where sindicato = 'Maica Bolivia' and registros_entregas.status = 'ENTREGADO') as Maica_Bolivia
      from personas
      LEFT JOIN registros_entregas
      ON registros_entregas.id_persona = personas.id", 
                    [
                        'status_entregado' => 'ENTREGADO',
                    ]
                    );
        return $data[0];
    }


    public static function getAllPersonWith(){

        return DB::table('personas')
        ->select('personas.*', 'registros_entregas.*', 'rubros.nombre_rubro')
        ->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
        ->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
        ->get();
    }
}
