<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\MarqueController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\WishlistController;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Public routes
Route::get('/produits/en-vedette', [ProduitController::class, 'enVedette']);
Route::get('/produits/{slug}', [ProduitController::class, 'show']);
Route::get('/produits/{id}/avis', [ProduitController::class, 'avis']);
Route::get('/produits/apparentes/{id}', [ProduitController::class, 'apparentes']);
Route::apiResource('produits', ProduitController::class)->only(['index']);

Route::apiResource('categories', CategorieController::class)->only(['index', 'show']);
Route::get('/categories/{slug}/enfants', [CategorieController::class, 'enfants']);

Route::apiResource('marques', MarqueController::class)->only(['index', 'show']);

// Cart routes (session-based)
Route::prefix('panier')->group(function () {
    Route::get('/', [PanierController::class, 'index']);
    Route::post('/ajouter', [PanierController::class, 'ajouter']);
    Route::put('/{rowId}', [PanierController::class, 'update']);
    Route::delete('/{rowId}', [PanierController::class, 'destroy']);
    Route::delete('/vider', [PanierController::class, 'vider']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
    });

    // Product reviews
    Route::post('/produits/{id}/avis', [ProduitController::class, 'ajouterAvis']);

    // Cart
    Route::prefix('panier')->group(function () {
        Route::get('/', [PanierController::class, 'index']);
        Route::post('/ajouter', [PanierController::class, 'ajouter']);
        Route::put('/{rowId}', [PanierController::class, 'update']);
        Route::delete('/{rowId}', [PanierController::class, 'destroy']);
        Route::delete('/vider', [PanierController::class, 'vider']);
    });

    // Orders
    Route::apiResource('commandes', CommandeController::class)->only(['index', 'show', 'store']);
    Route::put('/commandes/{id}/cancel', [CommandeController::class, 'cancel']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Wishlist
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('/ajouter', [WishlistController::class, 'ajouter']);
        Route::delete('/{produitId}', [WishlistController::class, 'destroy']);
    });

});


// Health check
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});
