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
            'name' => 'Usuario Entregador Producto',
            'email' => 'usuario1@cochabamba.bo',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'OPERADOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
