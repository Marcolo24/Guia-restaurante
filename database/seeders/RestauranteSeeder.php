<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestauranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restaurantes = [
            [
                'nombre' => 'La Tasca del Barrio',
                'descripcion' => 'Restaurante de comida tradicional',
                'precio_medio' => 20.50,
                'direccion' => 'Carrer del Consell de Cent, 23',
                'telefono' => '934567890',
                'web' => 'www.latascadelbarrio.com',
                'id_barrio' => 1,
                'imagen' => 'ruta/a/tu/imagen.jpg'
            ],
            [
                'nombre' => 'El Rincón de Gracia',
                'descripcion' => 'Restaurante vegetariano en el corazón de Gracia',
                'precio_medio' => 18.00,
                'direccion' => 'Carrer de Pau Claris, 50',
                'telefono' => '933456789',
                'web' => 'www.elrincondegracia.com',
                'id_barrio' => 2,
                'imagen' => 'restaurantes/rincon.jpg'
            ],
            [
                'nombre' => 'Sabor Mediterráneo',
                'descripcion' => 'Mariscos frescos y paellas típicas',
                'precio_medio' => 25.00,
                'direccion' => 'Carrer de la Marina, 150',
                'telefono' => '932345678',
                'web' => 'www.sabormediterraneo.com',
                'id_barrio' => 3,
                'imagen' => 'restaurantes/mediterraneo.jpg'
            ],
            [
                'nombre' => 'prueba2',
                'descripcion' => 'prueba',
                'precio_medio' => 20.00,
                'direccion' => 'Carrer del Consell de Cent, 22',
                'telefono' => '934567882',
                'web' => 'www.latascadelbarrio2.com',
                'id_barrio' => 1,
                'imagen' => 'restaurantes/prueba2.jpg'
            ],
            [
                'nombre' => 'restaurante',
                'descripcion' => 'restaurante',
                'precio_medio' => 21.00,
                'direccion' => 'Carrer del Consell de Cent, 17',
                'telefono' => '934567897',
                'web' => 'www.restaurante.com',
                'id_barrio' => 5,
                'imagen' => 'restaurantes/restaurante.jpg'
            ],
        ];

        foreach ($restaurantes as $restaurante) {
            DB::table('restaurante')->insert($restaurante);
        }
    }
}
