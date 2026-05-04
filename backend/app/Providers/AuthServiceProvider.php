<?php

namespace App\Providers;

use App\Models\Produit;
use App\Models\Commande;
use App\Models\Avis;
use App\Models\Category;
use App\Models\Marque;
use App\Policies\ProduitPolicy;
use App\Policies\CommandePolicy;
use App\Policies\AvisPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\MarquePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Produit::class => ProduitPolicy::class,
        Commande::class => CommandePolicy::class,
        Avis::class => AvisPolicy::class,
        Category::class => CategoryPolicy::class,
        Marque::class => MarquePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
