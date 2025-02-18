<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';
    
    protected $fillable = [
        'id_restaurante',
        'id_usuario',
        'puntuacion',
        'comentario'
    ];

    protected $casts = [
        'puntuacion' => 'decimal:1'
    ];

    // Desactivar timestamps si tu tabla no los tiene
    public $timestamps = true;

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'id_restaurante');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
} 