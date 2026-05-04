<?php

namespace App\Providers;

use App\Events\CommandeCreated;
use App\Events\CommandeStatusUpdated;
use App\Events\PaiementReceived;
use App\Events\AvisSubmitted;
use App\Events\UserRegistered;
use App\Events\ProduitOutOfStock;
use App\Listeners\SendOrderConfirmation;
use App\Listeners\SendStatusUpdateNotification;
use App\Listeners\SendPaymentReceipt;
use App\Listeners\NotifyAdminNewReview;
use App\Listeners\SendWelcomeEmail;
use App\Listeners\NotifyAdminOutOfStock;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CommandeCreated::class => [SendOrderConfirmation::class],
        CommandeStatusUpdated::class => [SendStatusUpdateNotification::class],
        PaiementReceived::class => [SendPaymentReceipt::class],
        AvisSubmitted::class => [NotifyAdminNewReview::class],
        UserRegistered::class => [SendWelcomeEmail::class],
        ProduitOutOfStock::class => [NotifyAdminOutOfStock::class],
    ];
}
