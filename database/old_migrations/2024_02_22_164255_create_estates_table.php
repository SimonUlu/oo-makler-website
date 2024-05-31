<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatesTable extends Migration
{
    public function up()
    {
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->unique();
            $table->string('type');
            $table->string('breitengrad')->nullable(); // Geändert von 'latitude'
            $table->string('laengengrad')->nullable(); // Geändert von 'longitude'
            $table->decimal('kaufpreis', 10, 2)->nullable(); // Geändert von 'price'
            $table->string('objekttitel'); // Geändert von 'title'
            $table->decimal('wohnflaeche', 10, 2)->nullable(); // Geändert von 'living_area'
            $table->string('vermarktungsart'); // Geändert von 'marketing_type'
            $table->string('plz'); // Geändert von 'postal_code'
            $table->string('ort'); // Geändert von 'city'
            $table->string('objektart'); // Geändert von 'estate_type'
            $table->year('baujahr')->nullable(); // Geändert von 'construction_year'
            $table->integer('anzahl_zimmer')->nullable(); // Geändert von 'rooms'
            $table->decimal('warmmiete', 10, 2)->nullable(); // Geändert von 'warm_rent'
            $table->boolean('veroeffentlichen')->default(false); // Geändert von 'publish'
            $table->decimal('kaltmiete', 10, 2)->nullable(); // Geändert von 'cold_rent'
            $table->boolean('stammobjekt')->default(false); // Geändert von 'is_main_estate'
            $table->string('status')->default(false); // Geändert von 'status', und Typ geändert zu string, falls es Textstatus ist
            $table->text('objektbeschreibung')->nullable(); // Geändert von 'description'
            $table->integer('etagen_zahl')->nullable(); // Geändert von 'floors'
            $table->decimal('gesamtflaeche', 10, 2)->nullable(); // Geändert von 'total_area'
            $table->integer('benutzer')->nullable(); // Geändert von 'floors'
            $table->integer('referenz')->nullable(); // Geändert von 'floors'
            // Hier können Sie weitere Felder hinzufügen, wie z.B. 'benutzer' und 'referenz'
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estates');
    }
}
