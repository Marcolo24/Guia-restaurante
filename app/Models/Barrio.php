<?php
// app/Models/Barrio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    use HasFactory;

    protected $table = 'barrio'; // Asegúrate de que el nombre de la tabla es correcto

    protected $primaryKey = 'id_barrio'; // Especificamos la clave primaria

    // public $timestamps = false; // Si no tienes columnas `created_at` y `updated_at`

    // Relación con los restaurantes
    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class, 'id_barrio', 'id_barrio');
    }
}
