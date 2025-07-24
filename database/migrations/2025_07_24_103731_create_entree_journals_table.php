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
    Schema::create('entree_journals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('journal_id')->constrained('journals')->onDelete('cascade'); // ici aussi "journals"
        $table->string('titre')->nullable();
        $table->longText('contenu');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entree_journals');
    }
};
