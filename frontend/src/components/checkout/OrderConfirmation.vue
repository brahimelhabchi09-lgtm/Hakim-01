<template>
  <div class="text-center py-12">
    <div class="w-20 h-20 bg-accent rounded-full flex items-center justify-center mx-auto mb-6">
      <CheckIcon class="h-10 w-10 text-white" />
    </div>
    <h1 class="text-3xl font-heading font-bold text-secondary mb-2">Commande confirmée!</h1>
    <p class="text-gray-600 mb-2">
      Votre commande <span class="font-bold text-primary">{{ order.num_commande }}</span> a ete passee avec succes.
    </p>
    <p class="text-sm text-gray-500 mb-8">
      Vous recevrez un email de confirmation bientot.
    </p>

    <div class="bg-gray-50 rounded-lg p-6 max-w-md mx-auto text-left">
      <h3 class="font-semibold mb-3">Details</h3>
      <div class="space-y-2 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">Total</span>
          <span class="font-bold text-primary">{{ order.total }} MAD</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Livraison a</span>
          <span class="text-right">{{ order.adresse_livraison?.ville }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Statut</span>
          <span class="badge-warning">{{ order.statut_label || 'En attente' }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Paiement</span>
          <span :class="order.statut_paiement === 'payee' ? 'badge-accent' : 'badge-warning'">
            {{ order.statut_paiement_label || 'En attente' }}
          </span>
        </div>
        <div v-if="order.mode_paiement" class="flex justify-between">
          <span class="text-gray-500">Mode de paiement</span>
          <span>{{ formatPaymentMethod(order.mode_paiement) }}</span>
        </div>
      </div>
    </div>

    <div class="flex gap-4 justify-center mt-8">
      <router-link to="/compte" class="btn-secondary">
        Voir mes commandes
      </router-link>
      <router-link to="/catalogue" class="btn-outline">
        Continuer les achats
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { CheckIcon } from '@heroicons/vue/24/solid'

defineProps({
  order: { type: Object, required: true },
})

function formatPaymentMethod(method) {
  const methods = {
    'cash': 'Paiement à la livraison',
  }
  return methods[method] || method
}
</script>
