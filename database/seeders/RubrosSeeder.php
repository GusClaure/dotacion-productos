<?php

namespace Database\Seeders;

use App\Models\Rubro;
use Illuminate\Database\Seeder;

class RubrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rubro::create([
            'nombre_rubro'  =>  'Ganaderia',
            'descripcion'  =>  'Rubro de ganaderia',
            'fecha_registro'  =>  now()
        ]);
    
        Rubro::create([
            'nombre_rubro'  =>  'Flores',
            'descripcion'  =>  'Rubro de Flores',
            'fecha_registro'  =>  now()
        ]);

        Rubro::create([
            'nombre_rubro'  =>  'Hortalizas',
            'descripcion'  =>  'Rubro Hortalizas',
            'fecha_registro'  =>  now()
        ]);

        Rubro::create([
            'nombre_rubro'  =>  'Animales Menores',
            'descripcion'  =>  'Rubro Animales Menores',
            'fecha_registro'  =>  now()
        ]);

        Rubro::create([
            'nombre_rubro'  =>  'Forraje',
            'descripcion'  =>  'Rubro Forraje',
            'fecha_registro'  =>  now()
        ]);

        Rubro::create([
            'nombre_rubro'  =>  'Agricola',
            'descripcion'  =>  'rubro Agricola',
            'fecha_registro'  =>  now()
        ]);
    }
}
