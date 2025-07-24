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
        Schema::create('dessins', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // nom du fichier (optionnel si tu veux le personnaliser)
            $table->string('chemin'); // chemin du fichier dans le stockage
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // lien avec l'utilisateur
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dessins');
    }
};
