<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre'  =>  'Ganaderia',
            'descripcion'  =>  'Categoria de ganaderia',
            'fecha_registro'  =>  now()
        ]);
    
        Categoria::create([
            'nombre'  =>  'Flores',
            'descripcion'  =>  'Categoria de Flores',
            'fecha_registro'  =>  now()
        ]);

        Categoria::create([
            'nombre'  =>  'Hortalizas',
            'descripcion'  =>  'Categoria Hortalizas',
            'fecha_registro'  =>  now()
        ]);

        Categoria::create([
            'nombre'  =>  'Animales Menores',
            'descripcion'  =>  'Categoria Animales Menores',
            'fecha_registro'  =>  now()
        ]);

        Categoria::create([
            'nombre'  =>  'Forraje',
            'descripcion'  =>  'Categoria Forraje',
            'fecha_registro'  =>  now()
        ]);
    }
}
