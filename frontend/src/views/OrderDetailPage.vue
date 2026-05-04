<template>
  <div class="container-custom py-8">
    <nav class="text-sm text-gray-500 mb-4">
      <router-link to="/" class="hover:text-primary">Accueil</router-link>
      /
      <router-link to="/compte" class="hover:text-primary">Mon Compte</router-link>
      /
      <span>Commande {{ order?.num_commande }}</span>
    </nav>

    <div v-if="order" class="max-w-2xl">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-heading font-bold">Commande {{ order.num_commande }}</h1>
        <span
          class="badge"
          :class="{
            'badge-warning': order.statut === 'en_attente',
            'badge-info': order.statut === 'en_cours',
            'badge-success': order.statut === 'livree',
          }"
        >
          {{ order.statut_label }}
        </span>
      </div>

      <div class="card p-6 space-y-4">
        <div>
          <h2 class="font-semibold mb-2">Articles</h2>
          <div v-for="item in order.items" :key="item.id" class="flex items-center gap-4 py-2 border-b">
            <img :src="item.produit?.image || '/placeholder-product.jpg'" class="w-12 h-12 object-cover rounded" />
            <div class="flex-1">
              <p class="text-sm font-medium">{{ item.produit?.nom }}</p>
              <p class="text-xs text-gray-500">x{{ item.quantite }}</p>
            </div>
            <p class="text-sm font-bold">{{ item.sous_total }} MAD</p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm pt-4">
          <div>
            <p class="text-gray-500">Adresse de livraison</p>
            <p class="font-medium">{{ order.adresse_livraison?.adresse }}</p>
            <p class="font-medium">{{ order.adresse_livraison?.ville }}</p>
          </div>
          <div>
            <p class="text-gray-500">Total</p>
            <p class="text-2xl font-bold text-primary">{{ order.total }} MAD</p>
          </div>
        </div>

        <div class="border-t pt-4 mt-4">
          <h3 class="font-semibold mb-2">Informations de paiement</h3>
          <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
              <p class="text-gray-500">Mode de paiement</p>
              <p class="font-medium">{{ formatPaymentMethod(order.mode_paiement) }}</p>
            </div>
            <div>
              <p class="text-gray-500">Statut du paiement</p>
              <span
                class="inline-block px-2 py-1 text-xs rounded"
                :class="{
                  'bg-green-100 text-green-800': order.statut_paiement === 'payee',
                  'bg-yellow-100 text-yellow-800': order.statut_paiement === 'en_attente',
                  'bg-red-100 text-red-800': order.statut_paiement === 'echec',
                  'bg-gray-100 text-gray-800': order.statut_paiement === 'rembourse',
                }"
              >
                {{ order.statut_paiement_label || 'En attente' }}
              </span>
            </div>
            <div v-if="order.montant_paye">
              <p class="text-gray-500">Montant payé</p>
              <p class="font-medium">{{ order.montant_paye }} MAD</p>
            </div>
            <div v-if="order.date_paiement">
              <p class="text-gray-500">Date de paiement</p>
              <p class="font-medium">{{ formatDate(order.date_paiement) }}</p>
            </div>
          </div>
        </div>

        <p class="text-sm text-gray-500">
          Commande le {{ formatDate(order.created_at) }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'

const route = useRoute()
const order = ref(null)

onMounted(async () => {
  try {
    const response = await api.get(`/commandes/${route.params.id}`)
    order.value = response.data.commande
  } catch {
    order.value = null
  }
})

function formatDate(date) {
  return new Date(date).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })
}

function formatPaymentMethod(method) {
  const methods = {
    'cash': 'Paiement à la livraison',
  }
  return methods[method] || method || 'Non spécifié'
}
</script>
