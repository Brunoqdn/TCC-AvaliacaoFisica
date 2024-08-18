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
        Schema::table('medidas', function (Blueprint $table) {
            $table->string('nome')->after('id'); // Adiciona a coluna "nome" após a coluna "id"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medidas', function (Blueprint $table) {
            $table->dropColumn('nome'); // Remove a coluna "nome" se a migration for revertida
        });
    }
};
