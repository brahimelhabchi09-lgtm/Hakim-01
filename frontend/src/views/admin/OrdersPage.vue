<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-heading font-bold mb-6">Commandes</h1>

      <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ error }}
        <button @click="fetchOrders" class="ml-4 underline">Réessayer</button>
      </div>

      <div class="flex gap-2 mb-4">
        <button
          v-for="s in ['all', 'en_attente', 'en_cours', 'expediee', 'livree', 'annulee']"
          :key="s"
          @click="filterStatut = s === 'all' ? '' : s; fetchOrders()"
          class="px-3 py-1 rounded-full text-sm border"
          :class="filterStatut === (s === 'all' ? '' : s) ? 'bg-primary text-white border-primary' : 'hover:bg-gray-50'"
        >
          {{ s === 'all' ? 'Toutes' : s.replace('_', ' ') }}
        </button>
      </div>

      <div class="card overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-4 text-sm font-medium text-gray-500">N° Commande</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Client</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Total</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Statut</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Date</th>
              <th class="text-right p-4 text-sm font-medium text-gray-500">Actions</th>
            </tr>
          </thead>
          <tbody v-if="!loading && commandes.length">
            <tr v-for="cmd in commandes" :key="cmd.id" class="border-t">
              <td class="p-4 font-medium text-sm">{{ cmd.num_commande }}</td>
              <td class="p-4 text-sm">{{ cmd.user?.prenom }} {{ cmd.user?.nom }}</td>
              <td class="p-4 text-sm font-bold">{{ cmd.total }} MAD</td>
              <td class="p-4">
                <select
                  :value="cmd.statut"
                  @change="updateStatut(cmd.id, $event.target.value)"
                  class="border rounded-md text-sm px-2 py-1"
                >
                  <option value="en_attente">En attente</option>
                  <option value="en_cours">En cours</option>
                  <option value="expediee">Expediee</option>
                  <option value="livree">Livree</option>
                  <option value="annulee">Annulee</option>
                </select>
              </td>
              <td class="p-4 text-sm text-gray-500">{{ formatDate(cmd.created_at) }}</td>
              <td class="p-4 text-right">
                <router-link :to="`/admin/commandes/${cmd.id}`" class="text-primary hover:underline text-sm">
                  Voir →
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="loading" class="p-8 text-center text-gray-500">
          Chargement...
        </div>
        <div v-else-if="!commandes.length && !error" class="p-8 text-center text-gray-500">
          Aucune commande trouvée.
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import { useToast } from '@/composables/useToast'
import api from '@/services/api'

const { success } = useToast()
const commandes = ref([])
const filterStatut = ref('')
const loading = ref(true)
const error = ref(null)

onMounted(fetchOrders)

async function fetchOrders() {
  loading.value = true
  error.value = null
  try {
    const params = {}
    if (filterStatut.value) params.statut = filterStatut.value
    const response = await api.get('/admin/commandes', { params })
    // API returns array directly
    commandes.value = response.data || []
  } catch (e) {
    console.error('Error loading orders:', e)
    if (e.response?.status === 401) {
      error.value = 'Non autorisé. Veuillez vous reconnecter.'
    } else {
      error.value = 'Erreur lors du chargement des commandes'
    }
    commandes.value = []
  } finally {
    loading.value = false
  }
}

async function updateStatut(id, statut) {
  try {
    await api.put(`/admin/commandes/${id}/statut`, { statut })
    success('Statut mis a jour')
    fetchOrders()
  } catch {
  }
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('fr-FR')
}
</script>
