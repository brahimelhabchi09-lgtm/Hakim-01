<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('mode_paiement')->nullable();
            $table->enum('statut_paiement', ['en_attente', 'payee', 'echec', 'rembourse'])->default('en_attente');
            $table->string('transaction_id')->nullable();
            $table->decimal('montant_paye', 10, 2)->nullable();
            $table->timestamp('date_paiement')->nullable();
            $table->json('payment_gateway_response')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn([
                'mode_paiement',
                'statut_paiement',
                'transaction_id',
                'montant_paye',
                'date_paiement',
                'payment_gateway_response'
            ]);
        });
    }
};
