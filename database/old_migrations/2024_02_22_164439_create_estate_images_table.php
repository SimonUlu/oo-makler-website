<?php

use App\Models\Estate;
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
        Schema::create('estate_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Estate::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('url');
            $table->string('title');
            $table->text('text')->nullable();
            $table->string('originalname');
            $table->unsignedBigInteger('modified');
            $table->unsignedBigInteger('estateMainId')->index(); // Zusätzlicher Fremdschlüssel, sollte auf estates.id verweisen
            $table->timestamps();

            // Optional: Fremdschlüssel-Constraints definieren, wenn die estates Tabelle bereits existiert
            // $table->foreign('estateid')->references('id')->on('estates')->onDelete('cascade');
            // $table->foreign('estateMainId')->references('id')->on('estates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estate_images');
    }
};
