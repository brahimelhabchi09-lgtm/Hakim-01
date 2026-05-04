<?php

namespace Tests\Unit;

use App\Events\CommandeCreated;
use App\Events\CommandeStatusUpdated;
use App\Models\Commande;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_commande_created_event()
    {
        $commande = Commande::factory()->create();
        $event = new CommandeCreated($commande);
        $this->assertEquals($commande->id, $event->commande->id);
    }

    public function test_commande_status_updated_event()
    {
        $commande = Commande::factory()->create();
        $event = new CommandeStatusUpdated($commande, 'en_cours', 'expediee');
        $this->assertEquals('en_cours', $event->oldStatus);
        $this->assertEquals('expediee', $event->newStatus);
    }
}
