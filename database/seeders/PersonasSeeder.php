<?php

namespace Database\Seeders;

use App\Models\personas;
use Illuminate\Database\Seeder;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $csvFile = fopen(base_path("prof.csv"), "r");
        // $firstline = true;
        // while (($data = fgetcsv($csvFile, 0, ";")) !== FALSE) {
        //     if (!$firstline) {
        //         personas::create([
        //             "nro_formulario" => $data[1],
        //             "nro_cel" => $data[2],
        //             "nombre" => $data[3],
        //             "primer_ap" => $data[4],
        //             "segundo_ap" => $data[5],
        //             "ci" => $data[6],
        //             "expedido" => $data[7],
        //             "distrito" => $data[8],
        //             "sub_central" => $data[9],
        //             "sindicato" => $data[10],
        //             "x_coord" => $data[16],
        //             "y_coord" => $data[17]
        //         ]);    
        //     }
        //     $firstline = false;
        // }
   
        // fclose($csvFile);

    }
}
