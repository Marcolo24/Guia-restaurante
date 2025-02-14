<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarrioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barrios = [
            'Gótico', 'El Born', 'El Raval', 'Barceloneta', 'Eixample', 'Gràcia', 
            'Poblenou', 'Sants', 'Les Corts', 'Sarrià-Sant Gervasi', 'Horta-Guinardó', 
            'Sant Andreu', 'El Clot', 'Poble-sec', 'Vila Olímpica', 'Sant Antoni', 
            'Pedralbes', 'Dreta de l’Eixample', 'Esquerra de l’Eixample', 'Fort Pienc'
        ];

        foreach ($barrios as $barrio) {
            DB::table('barrio')->insert([
                'barrio' => $barrio
            ]);
        }
    }
}
