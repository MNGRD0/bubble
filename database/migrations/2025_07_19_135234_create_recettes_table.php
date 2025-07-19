<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recettes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('ingredients')->nullable(); // Liste d’ingrédients
            $table->text('etapes')->nullable();      // Étapes de préparation
            $table->string('image')->nullable();     // Image facultative

            // ✅ Clé étrangère corrigée avec le bon nom de table
            $table->foreignId('categorie_recette_id')
                  ->constrained('categories_recettes')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade'); // Propriétaire de la recette

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recettes');
    }
};
