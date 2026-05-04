<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <div class="flex items-center gap-4 mb-6">
        <router-link to="/admin/commandes" class="text-gray-500 hover:text-primary">← Retour</router-link>
        <h1 class="text-2xl font-heading font-bold">Commande {{ commande?.num_commande }}</h1>
      </div>

      <div v-if="commande" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 card p-6 space-y-4">
          <h2 class="font-semibold">Articles</h2>
          <div v-for="item in commande.items" :key="item.id" class="flex items-center gap-4 py-2 border-b">
            <img :src="item.produit?.image || '/placeholder-product.jpg'" class="w-12 h-12 object-cover rounded" />
            <div class="flex-1">
              <p class="font-medium">{{ item.produit?.nom }}</p>
              <p class="text-sm text-gray-500">x{{ item.quantite }} à {{ item.prix_unitaire }} MAD</p>
            </div>
            <p class="font-bold">{{ item.sous_total }} MAD</p>
          </div>
        </div>

        <div class="card p-6 space-y-4">
          <h2 class="font-semibold">Details</h2>
          <div class="space-y-2 text-sm">
            <div>
              <p class="text-gray-500">Statut</p>
              <select
                :value="commande.statut"
                @change="updateStatut($event.target.value)"
                class="w-full border rounded-md px-3 py-2 mt-1"
              >
                <option value="en_attente">En attente</option>
                <option value="en_cours">En cours</option>
                <option value="expediee">Expediee</option>
                <option value="livree">Livree</option>
                <option value="annulee">Annulee</option>
              </select>
            </div>
            <div>
              <p class="text-gray-500">Total</p>
              <p class="text-2xl font-bold text-primary">{{ commande.total }} MAD</p>
            </div>
            <div>
              <p class="text-gray-500">Livraison</p>
              <p>{{ commande.adresse_livraison?.adresse }}</p>
              <p>{{ commande.adresse_livraison?.ville }}</p>
              <p>{{ commande.adresse_livraison?.telephone }}</p>
            </div>
            <div>
              <p class="text-gray-500">Client</p>
              <p>{{ commande.user?.prenom }} {{ commande.user?.nom }}</p>
              <p>{{ commande.user?.email }}</p>
            </div>
          </div>
        </div>

        <div class="card p-6 space-y-4">
          <h2 class="font-semibold">Paiement</h2>
          <div class="space-y-2 text-sm">
            <div>
              <p class="text-gray-500">Mode</p>
              <p class="font-medium">{{ formatPaymentMethod(commande.mode_paiement) }}</p>
            </div>
            <div>
              <p class="text-gray-500">Statut</p>
              <select
                :value="commande.statut_paiement"
                @change="updateStatutPaiement($event.target.value)"
                class="w-full border rounded-md px-3 py-2 mt-1"
              >
                <option value="en_attente">En attente</option>
                <option value="payee">Payee</option>
                <option value="echec">Echec</option>
                <option value="rembourse">Rembourse</option>
              </select>
            </div>
            <div v-if="commande.montant_paye">
              <p class="text-gray-500">Montant payé</p>
              <p class="font-medium">{{ commande.montant_paye }} MAD</p>
            </div>
            <div v-if="commande.transaction_id">
              <p class="text-gray-500">Transaction ID</p>
              <p class="font-mono text-xs">{{ commande.transaction_id }}</p>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import { useToast } from '@/composables/useToast'
import api from '@/services/api'

const route = useRoute()
const { success, error } = useToast()
const commande = ref(null)

onMounted(async () => {
  try {
    const response = await api.get(`/admin/commandes/${route.params.id}`)
    commande.value = response.data.commande
  } catch {
  }
})

async function updateStatut(statut) {
  try {
    await api.put(`/admin/commandes/${route.params.id}/statut`, { statut })
    commande.value.statut = statut
    success('Statut mis a jour')
  } catch {
  }
}

async function updateStatutPaiement(statutPaiement) {
  try {
    await api.put(`/admin/commandes/${route.params.id}/statut-paiement`, { statut_paiement: statutPaiement })
    commande.value.statut_paiement = statutPaiement
    success('Statut de paiement mis a jour')
  } catch {
  }
}

function formatPaymentMethod(method) {
  const methods = {
    'cash': 'Paiement à la livraison',
  }
  return methods[method] || method || 'Non spécifié'
}
</script>
