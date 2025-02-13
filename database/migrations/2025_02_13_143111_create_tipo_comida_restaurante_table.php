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

        Schema::create('tipo_comida_restaurante', function (Blueprint $table) {
            $table->id('id_tipo_comida_restaurante');
            $table->unsignedBigInteger('id_restaurante');
            $table->foreign('id_restaurante')->references('id_restaurante')->on('restaurante');
            $table->unsignedBigInteger('id_tipo_comida');
            $table->foreign('id_tipo_comida')->references('id_tipo_comida')->on('tipo_comida');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_comida_restaurante');
    }
};
