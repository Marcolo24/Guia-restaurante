<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('restaurante', function (Blueprint $table) {
            $table->id('id_restaurante');
            $table->string('nombre');
            $table->string('descripcion');
            $table->decimal('precio_medio', 6, 2);
            $table->string('direccion');
            $table->integer('telefono');
            $table->string('web');
            $table->string('imagen')->nullable(); 
            $table->unsignedBigInteger('id_barrio');
            $table->foreign('id_barrio')->references('id_barrio')->on('barrio');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurante');
    }
};
