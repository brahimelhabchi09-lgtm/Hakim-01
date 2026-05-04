<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-heading font-bold mb-6">Dashboard</h1>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <StatsCard label="Ventes du jour" :value="`${stats.ventes?.today || 0} MAD`" icon="CurrencyDollarIcon" color="accent" />
        <StatsCard label="Commandes en attente" :value="stats.commandes?.en_attente || 0" icon="ShoppingBagIcon" color="warning" />
        <StatsCard label="Total Produits" :value="stats.produits?.total || 0" icon="Squares2X2Icon" color="primary" />
        <StatsCard label="Stock faible" :value="stats.produits?.low_stock || 0" icon="ExclamationTriangleIcon" color="error" />
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card p-6">
          <h2 class="font-semibold mb-4">Commandes recentes</h2>
          <div v-if="stats.recent_commandes?.length" class="space-y-3">
            <div v-for="cmd in stats.recent_commandes" :key="cmd.id" class="flex items-center justify-between py-2 border-b">
              <div>
                <p class="font-medium text-sm">{{ cmd.num_commande }}</p>
                <p class="text-xs text-gray-500">{{ cmd.user?.prenom }} {{ cmd.user?.nom }}</p>
              </div>
              <div class="text-right">
                <p class="font-bold text-sm text-primary">{{ cmd.total }} MAD</p>
                <span class="badge" :class="cmd.statut === 'en_attente' ? 'badge-warning' : 'badge-info'">
                  {{ cmd.statut }}
                </span>
              </div>
            </div>
          </div>
          <p v-else class="text-gray-500 text-sm">Aucune commande.</p>
        </div>

        <div class="card p-6">
          <h2 class="font-semibold mb-4">Avis recents</h2>
          <div v-if="stats.recent_avis?.length" class="space-y-3">
            <div v-for="avis in stats.recent_avis" :key="avis.id" class="flex items-center justify-between py-2 border-b">
              <div>
                <p class="font-medium text-sm">{{ avis.produit?.nom }}</p>
                <p class="text-xs text-gray-500">{{ avis.user?.prenom }} - Note: {{ avis.note }}/5</p>
              </div>
              <span class="badge badge-warning">{{ avis.statut_label }}</span>
            </div>
          </div>
          <p v-else class="text-gray-500 text-sm">Aucun avis.</p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import StatsCard from '@/components/admin/StatsCard.vue'
import { CurrencyDollarIcon, ShoppingBagIcon, Squares2X2Icon, ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import api from '@/services/api'

const stats = ref({})

onMounted(async () => {
  try {
    const response = await api.get('/admin/dashboard-stats')
    stats.value = response.data
  } catch {
    stats.value = {}
  }
})
</script>
