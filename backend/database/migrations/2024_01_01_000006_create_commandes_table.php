<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('num_commande')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('statut', ['en_attente', 'en_cours', 'expediee', 'livree', 'annulee'])->default('en_attente');
            $table->decimal('total', 10, 2);
            $table->decimal('frais_livraison', 10, 2)->default(0);
            $table->json('adresse_livraison')->nullable();
            $table->json('adresse_facturation')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
