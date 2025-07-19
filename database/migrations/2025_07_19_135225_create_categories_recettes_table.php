<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories_recettes', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Le nom de la catégorie
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien avec l'utilisateur
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories_recettes');
    }
};
