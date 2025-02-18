<?php

namespace Database\Seeders;

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
            'Española', 'Italiana', 'Vegetariana', 'Mexicana', 'Japonesa',
            'Francesa', 'China', 'India', 'Tailandesa', 'Mediterránea',
            'Griega', 'Turca', 'Libanesa', 'Americana', 'Argentina',
            'Peruana', 'Coreana', 'Vietnamita', 'Africana', 'Brasileña',
            'Alemana', 'Marroquí', 'Indonesia', 'Filipina', 'Caribeña',
            'Rusa', 'Etíope', 'Árabe', 'Kosher', 'Hawaiana', 'Cubana',
            'Portuguesa', 'Polaca', 'Sueca', 'Noruega', 'Danesa'
        ];

        foreach ($tiposComida as $tipo) {
            DB::table('tipo_comida')->insert([
                'nombre' => 'Comida ' . $tipo
            ]);
        }
    }
}
