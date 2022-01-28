<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::raw('CREATE EXTENSION IF NOT EXISTS "pgcrypto"');
        DB::table('users')->insert([
            'name' => 'Gustavo Claure Flores',
            'email' => 'gclaure@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'ADMIN',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Coro Canaviri Diego Weimar',
            'email' => 'ccanaviri@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('5194660'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Cary Cruz Rene Alejandro',
            'email' => 'ccruz@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('3027407'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Nelly Vidal Almanza',
            'email' => 'nvidal@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('6401176'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Vasquez Sanchez Ronald',
            'email' => 'vsanchez@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('7891911'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Siles Borda Ramiro',
            'email' => 'sborda@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('3143568'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Angulo Santos Carmelo',
            'email' => 'asantos@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('3028168'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Santa Cruz Carrasco Victor',
            'email' => 'scruz@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('3744288'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Lazarte Rodriguez Julio Cesar',
            'email' => 'lrodriguez@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('7890489'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

//     nombre	usuario	password
// Coro Canaviri Diego Weimar	ccanaviri@cochabamba.bo	5194660
// Cary Cruz Rene Alejandro	ccruz@cochabamba.bo	3027407
// Nelly Vidal Almanza	nvidal@cochabamba.bo	6401176
// Vasquez Sanchez Ronald	vsanchez@cochabamba.bo	7891911
// Siles Borda Ramiro	sborda@cochabamba.bo	3143568
// Angulo Santos Carmelo	asantos@cochabamba.bo	3028168
// Lazarte Rodriguez Julio Cesar	lrodriguez@cochabamba.bo	7890489

}
