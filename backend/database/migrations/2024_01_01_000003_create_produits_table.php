<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->decimal('prix_promotionnel', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->string('pays_origine', 20)->nullable();
            $table->json('tags')->nullable();
            $table->decimal('avis_moyenne', 3, 2)->default(0);
            $table->integer('avis_total')->default(0);
            $table->boolean('en_vedette')->default(false);
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('marque_id')->nullable()->constrained('marques')->nullOnDelete();
            $table->timestamps();

            $table->index(['category_id', 'marque_id']);
            $table->index(['en_vedette']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
