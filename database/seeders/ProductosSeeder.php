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
            'nombre'  =>  'Promotor Vitaminico',
            'descripcion'  =>  'PROMOTOR “L” es una fórmula donde se incluyen las vitaminas y aminoácidos, en concentraciones adecuadas, indispensables para el correcto funcionamiento del fisiologismo orgánico. Su presentación en forma líquida evita las dificultades que pudieran aparecer con algunos tipos de bebederos automáticos.'
        ]);

        producto::create([
            'nombre'  =>  'Suplemento ni idea',
            'descripcion'  =>  'descripcion'
        ]);

        producto::create([
            'nombre'  =>  'Alimento Balanceado',
            'descripcion'  =>  'Los ALIMENTOS BALANCEADOS, son mezclas homogéneas de varios alimentos, formulados en cantidad y proporción para satisfacer en lo posible todas las necesidades alimenticias y nutricionales de una especie animal durante un periodo de 24'
        ]);

        producto::create([
            'nombre'  =>  'Ganado Vacuno',
            'descripcion'  =>  'Los ALIMENTOS BALANCEADOS, son mezclas homogéneas de varios alimentos, formulados en cantidad y proporción para satisfacer en lo posible todas las necesidades alimenticias y nutricionales de una especie animal durante un periodo de 24'
        ]);

        producto::create([
            'nombre'  =>  'Fertilizante Urea',
            'descripcion'  =>  'Los ALIMENTOS BALANCEADOS, son mezclas homogéneas de varios alimentos, formulados en cantidad y proporción para satisfacer en lo posible todas las necesidades alimenticias y nutricionales de una especie animal durante un periodo de 24'
        ]);
    }
}
