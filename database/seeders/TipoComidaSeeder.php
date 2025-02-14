<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoComidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposComida = [
            'Vegana', 'Vegetariana', 'Italiana', 'Mexicana', 'Japonesa', 'China', 
            'India', 'Tailandesa', 'Mediterránea', 'Francesa', 'Griega', 'Turca', 
            'Libanesa', 'Americana', 'Argentina', 'Peruana', 'Coreana', 'Vietnamita', 
            'Africana', 'Brasileña', 'Española', 'Alemana', 'Marroquí', 'Indonesia', 
            'Filipina', 'Caribeña', 'Rusa', 'Etíope', 'Árabe', 'Kosher'
        ];

        foreach ($tiposComida as $tipo) {
            DB::table('tipo_comida')->insert([
                'nombre' => $tipo
            ]);
        }
    }
}
