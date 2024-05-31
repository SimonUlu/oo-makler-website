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
        Schema::create('geo_areas', function (Blueprint $table) {
            $table->id();
            $table->integer('Year');
            $table->string('Kreis_code');
            $table->string('Kreis_name');
            $table->string('Kreis_name_short');
            $table->string('Type');
            $table->string('Land_code');
            $table->string('Land_name');
            $table->string('ISO_3166_3_Area_code');
            $table->json('geometry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('geo_areas');
    }
};
