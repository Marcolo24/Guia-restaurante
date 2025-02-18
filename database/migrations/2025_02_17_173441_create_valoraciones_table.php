<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('valoraciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_restaurante');
            $table->unsignedBigInteger('id_usuario');
            $table->decimal('puntuacion', 2, 1);
            $table->text('comentario')->nullable();
            $table->timestamps();

            $table->foreign('id_restaurante')
                  ->references('id_restaurante')
                  ->on('restaurante')
                  ->onDelete('cascade');
            
            // Cambiamos la referencia a 'id_usuario' en lugar de 'id'
            $table->foreign('id_usuario')
                  ->references('id_usuario')  // Asumiendo que tu tabla users usa 'id_usuario'
                  ->on('users')
                  ->onDelete('cascade');
            
            // Un usuario solo puede tener una valoración por restaurante
            $table->unique(['id_restaurante', 'id_usuario']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('valoraciones');
    }
}; 