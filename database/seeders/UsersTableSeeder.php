<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nombre' => 'admin',
                'correo' => 'admin@bcnfoodie.com',
                'id_rol' => 1,
                'contrasena' => Hash::make('qweQWE123'),
            ],
            [
                'nombre' => 'usuario',
                'correo' => 'usuario@bcnfoodie.com',
                'id_rol' => 2,
                'contrasena' => Hash::make('qweQWE123'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
