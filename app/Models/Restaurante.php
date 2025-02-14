<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;
    // Definir las columnas que pueden ser llenadas de forma masiva
    protected $table = 'restaurante';
    protected $fillable = [
        'nombre',
        'direccion',
        'foto',
    ];

    /**
     * Relación de muchos a muchos con TipoComida.
     * 
     * Esta función define la relación de muchos a muchos entre los restaurantes
     * y los tipos de comida que ofrecen.
     */
    public function tiposComida()
    {
        return $this->belongsToMany(TipoComida::class, 'tipo_comida_restaurante');
    }
}
