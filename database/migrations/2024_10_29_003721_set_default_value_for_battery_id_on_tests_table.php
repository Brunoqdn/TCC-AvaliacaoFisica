<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tests', function (Blueprint $table) {
        $table->unsignedBigInteger('battery_id')->default(1)->change(); // Defina o valor padrão desejado
    });
}

public function down()
{
    Schema::table('tests', function (Blueprint $table) {
        $table->unsignedBigInteger('battery_id')->default(null)->change();
    });
}

};
