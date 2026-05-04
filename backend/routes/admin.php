<?php

use App\Http\Controllers\Api\Admin\AdminAvisController;
use App\Http\Controllers\Api\Admin\AdminCategorieController;
use App\Http\Controllers\Api\Admin\AdminCommandeController;
use App\Http\Controllers\Api\Admin\AdminMarqueController;
use App\Http\Controllers\Api\Admin\AdminProduitController;
use App\Http\Controllers\Api\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard-stats', [DashboardController::class, 'stats']);

    // Products CRUD
    Route::apiResource('produits', AdminProduitController::class);

    // Categories CRUD
    Route::apiResource('categories', AdminCategorieController::class)->except(['show']);

    // Brands CRUD
    Route::apiResource('marques', AdminMarqueController::class)->except(['show']);

    // Orders management
    Route::get('/commandes', [AdminCommandeController::class, 'index']);
    Route::get('/commandes/{id}', [AdminCommandeController::class, 'show']);
    Route::put('/commandes/{id}/statut', [AdminCommandeController::class, 'updateStatut']);
    Route::put('/commandes/{id}/statut-paiement', [AdminCommandeController::class, 'updateStatutPaiement']);

    // Reviews moderation
    Route::get('/avis', [AdminAvisController::class, 'index']);
    Route::put('/avis/{id}/approuve', [AdminAvisController::class, 'approuve']);
    Route::put('/avis/{id}/rejete', [AdminAvisController::class, 'rejete']);
    Route::delete('/avis/{id}', [AdminAvisController::class, 'destroy']);
});
