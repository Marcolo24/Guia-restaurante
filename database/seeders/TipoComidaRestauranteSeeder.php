<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoComidaRestauranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoComidaRestaurantes = [
            ['id_restaurante' => 5, 'id_tipo_comida' => 1],
            ['id_restaurante' => 3, 'id_tipo_comida' => 3],
            ['id_restaurante' => 4, 'id_tipo_comida' => 2],
            ['id_restaurante' => 8, 'id_tipo_comida' => 5],
            ['id_restaurante' => 2, 'id_tipo_comida' => 5],
        ];

        foreach ($tipoComidaRestaurantes as $entry) {
            DB::table('tipo_comida_restaurante')->insert($entry);
        }
    }
}
