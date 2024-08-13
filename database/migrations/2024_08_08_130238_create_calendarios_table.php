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
        Schema::create('calendarios', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->String('horarios');
            $table->string('mes');
            $table->timestamp('data');
            $table->enum('periodo', ['manhã', 'tarde', 'noite']);
            $table->enum('status', ['Reservado', 'Disponivel']);
            $table->unsignedBigInteger('empresaId')->nullable();
            $table->foreign('empresaId')->references('id')->on('empresas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendarios');
    }
};
