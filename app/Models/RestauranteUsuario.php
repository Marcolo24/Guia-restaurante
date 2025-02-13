<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestauranteUsuario extends Model
{
    use HasFactory;

    protected $table = 'restaurante_usuario';

    // Definir los campos asignables en masa
    protected $fillable = [
        'id_restaurante',
        'id_usuario',
        'puntuacion',
        'comentario',
    ];

    // Relación con Restaurante (muchos a uno)
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }

    // Relación con Usuario (muchos a uno)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
