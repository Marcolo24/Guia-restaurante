<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['rol' => 'Admin'],
            ['rol' => 'Usuario'],
        ];

        foreach ($roles as $rol) {
            DB::table('rol')->insert($rol);
        }
    }
}
