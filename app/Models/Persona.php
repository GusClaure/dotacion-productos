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
        'fecha_nacimiento',
        'lugar_nacimiento',
        'genero',
        'estado_civil',
        'ocupacion',
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
        count(1) filter (where registros_entregas.status is null or registros_entregas.status = 'ANULADO') as total_pendientes,
        count(1) filter (where registros_entregas.status = 'PENDIENTE-PRODUCTO') as total_pendientes_producto,
        count(1) filter (where sub_central ilike '%Valle Hermoso%' and registros_entregas.status = 'ENTREGADO') as valle_hermoso,
        count(1) filter (where sub_central ilike '%Pucara grande%' and registros_entregas.status = 'ENTREGADO') as pucara_grande,
        count(1) filter (where sub_central ilike '%Azirumarca%' and registros_entregas.status = 'ENTREGADO') as azirumarca,
        count(1) filter (where sub_central ilike '%Maica%' and registros_entregas.status = 'ENTREGADO') as maica,
        count(1) filter (where sub_central ilike '%Campesino Norte%' and registros_entregas.status = 'ENTREGADO') as campesino_norte
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

    public static function getAllPersonsWithSindicates($sindicato){
        return DB::table('personas')
        ->select('personas.*', 'registros_entregas.*', 'rubros.nombre_rubro')
        ->leftjoin('registros_entregas', 'personas.id', '=', 'registros_entregas.id_persona')
        ->leftjoin('rubros', 'personas.rubro_id', '=', 'rubros.id')
        ->where('sindicato', $sindicato)
        ->get();
    }

    public static function getAllSindicatos(){

        return DB::table('personas')
        ->select('sindicato')
        ->distinct('sindicato')
        ->orderBy('sindicato', 'asc')
        ->get();
    }
}
