<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('commande.{commandeId}', function ($user, $commandeId) {
    return $user->commandes->contains('id', $commandeId) || $user->is_admin;
});
