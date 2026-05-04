<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <h1 class="text-2xl font-heading font-bold mb-6">Avis clients</h1>

      <div class="flex gap-2 mb-4">
        <button
          v-for="s in ['all', 'en_attente', 'approuve', 'rejete']"
          :key="s"
          @click="filterStatut = s === 'all' ? '' : s; fetchReviews()"
          class="px-3 py-1 rounded-full text-sm border"
          :class="filterStatut === (s === 'all' ? '' : s) ? 'bg-primary text-white border-primary' : 'hover:bg-gray-50'"
        >
          {{ s === 'all' ? 'Tous' : s === 'en_attente' ? 'En attente' : s === 'approuve' ? 'Approuves' : 'Rejetes' }}
        </button>
      </div>

      <div class="card p-6 space-y-4">
        <div v-if="avis.length === 0" class="text-center py-8 text-gray-500">
          <p>Aucun avis.</p>
        </div>

        <div v-for="review in avis" :key="review.id" class="flex items-start justify-between py-4 border-b">
          <div>
            <div class="flex items-center gap-2">
              <span class="font-medium">{{ review.user?.nom }}</span>
              <span class="text-gray-500">sur</span>
              <router-link :to="`/produit/${review.produit?.slug}`" class="text-primary hover:underline">
                {{ review.produit?.nom }}
              </router-link>
            </div>
            <div class="flex items-center gap-2 mt-1">
              <span class="text-yellow-500">★</span>
              <span class="text-sm">{{ review.note }}/5</span>
              <span class="text-xs text-gray-400">{{ formatDate(review.created_at) }}</span>
            </div>
            <p v-if="review.titre" class="font-medium text-sm mt-1">{{ review.titre }}</p>
            <p v-if="review.contenu" class="text-sm text-gray-600 mt-1">{{ review.contenu }}</p>
          </div>
          <div class="flex items-center gap-2 ml-4">
            <span class="badge" :class="review.statut === 'approuve' ? 'badge-success' : review.statut === 'rejete' ? 'badge-danger' : 'badge-warning'">
              {{ review.statut_label }}
            </span>
            <button v-if="review.statut !== 'approuve'" @click="approve(review.id)" class="text-accent hover:text-accent-600 text-sm">
              Approuver
            </button>
            <button v-if="review.statut !== 'rejete'" @click="reject(review.id)" class="text-red-500 hover:text-red-600 text-sm">
              Rejeter
            </button>
          </div>
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
const avis = ref([])
const filterStatut = ref('')

onMounted(fetchReviews)

async function fetchReviews() {
  try {
    const params = {}
    if (filterStatut.value) params.statut = filterStatut.value
    const response = await api.get('/admin/avis', { params })
    avis.value = response.data.data
  } catch {
    avis.value = []
  }
}

async function approve(id) {
  try {
    await api.put(`/admin/avis/${id}/approuve`)
    success('Avis approuve')
    fetchReviews()
  } catch {
  }
}

async function reject(id) {
  try {
    await api.put(`/admin/avis/${id}/rejete`)
    success('Avis rejete')
    fetchReviews()
  } catch {
  }
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('fr-FR')
}
</script>
