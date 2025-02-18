<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla si es diferente al predeterminado
    protected $table = 'restaurante';
    protected $primaryKey = 'id_restaurante';

    // Deshabilitar timestamps ya que no existen en la tabla
    public $timestamps = false;

    // Definir las columnas que pueden ser llenadas de forma masiva
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_medio',
        'direccion',
        'telefono',
        'web',
        'imagen',
        'id_barrio',
    ];

    // Relación con la tabla 'barrio' (uno a muchos)
    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'id_barrio');
    }

    // Relación con los tipos de comida (muchos a muchos)
    public function tiposComida()
    {
        return $this->belongsToMany(
            TipoComida::class,
            'tipo_comida_restaurante',
            'id_restaurante',
            'id_tipo_comida'
        );
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'id_restaurante');
    }
}
