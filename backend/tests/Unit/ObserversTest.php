<?php

namespace Tests\Unit;

use App\Observers\ProduitObserver;
use App\Observers\CommandeObserver;
use App\Observers\UserObserver;
use Tests\TestCase;

class ObserversTest extends TestCase
{
    public function test_produit_observer_exists()
    {
        $this->assertTrue(class_exists(ProduitObserver::class));
    }

    public function test_commande_observer_exists()
    {
        $this->assertTrue(class_exists(CommandeObserver::class));
    }

    public function test_user_observer_exists()
    {
        $this->assertTrue(class_exists(UserObserver::class));
    }
}
