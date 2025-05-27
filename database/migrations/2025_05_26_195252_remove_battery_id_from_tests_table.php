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
        Schema::table('tests', function (Blueprint $table) {
            // Primeiro, remova a foreign key (se existir)
            $table->dropForeign(['battery_id']);
            
            // Depois, remova a coluna
            $table->dropColumn('battery_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            // Reverte a alteração se necessário
            $table->unsignedBigInteger('battery_id')->nullable();

            $table->foreign('battery_id')->references('id')->on('test_batteries')->onDelete('cascade');
        });
    }
};
