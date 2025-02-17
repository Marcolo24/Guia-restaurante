<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoComida extends Model
{
    use HasFactory;
    protected $table = 'tipo_comida';
    protected $primaryKey = 'id_tipo_comida';
    // Definir las columnas que pueden ser llenadas de forma masiva
    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación de muchos a muchos con Restaurante.
     * 
     * Esta función define la relación de muchos a muchos entre los tipos de comida
     * y los restaurantes que los ofrecen.
     */
    public function restaurantes()
    {
        return $this->belongsToMany(
            Restaurante::class,
            'tipo_comida_restaurante',
            'id_tipo_comida',
            'id_restaurante'
        );
    }
}
