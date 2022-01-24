<?php

namespace Database\Seeders;

use App\Models\producto;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        producto::create([
            'nombre_producto'  =>  'Alimento Balanceado para Ganado Vacuno Lechero',
            'cantidad'  =>  '15.385,00',
            'unidad' => 'Bolsas 46 kg.'
        ]);

        producto::create([
            'nombre_producto'  =>  'Alimento Balanceado para Ganado Vacuno de Engorde',
            'cantidad'  =>  '15.385,00',
            'unidad' => 'Bolsas 46 kg.'
        ]);

        producto::create([
            'nombre_producto'  =>  'Promotor (vitamínico y mineral) de producción láctea para ganado vacuno',
            'cantidad'  =>  '10.274,00',
            'unidad' => 'Bolsas 46 kg.'
        ]);

        producto::create([
            'nombre_producto'  =>  'Suplemento Mineral para Ganado Vacuno',
            'cantidad'  =>  '10.417,00',
            'unidad' => 'Bolsas 46 kg.'
        ]);

        producto::create([
            'nombre_producto'  =>  'Fertilizante Urea 46% N granulado',
            'cantidad'  =>  '6.128,00',
            'unidad' =>'Bolsas 50 kg.'
        ]);
    }
}
