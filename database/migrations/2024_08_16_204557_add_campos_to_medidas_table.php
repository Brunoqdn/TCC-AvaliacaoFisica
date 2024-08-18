<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medidas', function (Blueprint $table) {
            $table->decimal('flexibilidade', 8, 2)->nullable();
            $table->integer('abdominais')->nullable();
            $table->integer('corrida6min')->nullable();
            $table->integer('medicineBall')->nullable();
            $table->integer('saltoHorizontal')->nullable();
            $table->decimal('quadrado', 8, 2)->nullable();
            $table->decimal('corrida20m', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medidas', function (Blueprint $table) {
            $table->dropColumn([
                'flexibilidade', 
                'abdominais', 
                'corrida6min', 
                'medicineBall', 
                'saltoHorizontal', 
                'quadrado', 
                'corrida20m'
            ]);
        });
    }
}
