<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('valoraciones', function (Blueprint $table) {
            // Añadir la foreign key que falta
            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Añadir índice único para evitar valoraciones duplicadas
            $table->unique(['id_restaurante', 'id_usuario']);
        });
    }

    public function down()
    {
        Schema::table('valoraciones', function (Blueprint $table) {
            $table->dropForeign(['id_usuario']);
            $table->dropUnique(['id_restaurante', 'id_usuario']);
        });
    }
}; 