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
        Schema::create('percentis', function (Blueprint $table) {
            $table->id();
            $table->integer('idade');
            $table->enum('sexo', ['M', 'F']);
            $table->string('tipo_exercicio', 50);
            $table->integer('percentil_fraco')->nullable();
            $table->integer('percentil_razoavel')->nullable();
            $table->integer('percentil_bom')->nullable();
            $table->integer('percentil_muito_bom')->nullable();
            $table->integer('percentil_excelente')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('percentis');
    }
};
