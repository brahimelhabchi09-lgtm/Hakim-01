<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('produit_id')->constrained('produits')->cascadeOnDelete();
            $table->tinyInteger('note')->unsigned();
            $table->string('titre')->nullable();
            $table->text('contenu')->nullable();
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->timestamps();

            $table->unique(['user_id', 'produit_id']);
            $table->index(['produit_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
