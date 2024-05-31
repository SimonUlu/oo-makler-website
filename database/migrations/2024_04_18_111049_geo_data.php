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
        Schema::create('geo_data', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('plz_name', 255);
            $table->string('plz_name_long', 255);
            $table->string('plz_code', 10);
            $table->string('krs_code', 50);
            $table->string('lan_name', 100);
            $table->string('lan_code', 10);
            $table->string('krs_name', 100);
            $table->json('geo_point_2d');
            $table->json('geometry');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_data');
    }
};
