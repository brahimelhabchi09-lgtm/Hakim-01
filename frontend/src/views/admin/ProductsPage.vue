<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-heading font-bold">Produits</h1>
        <router-link to="/admin/produits/creer" class="btn-primary">
          Ajouter un produit
        </router-link>
      </div>

      <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ error }}
        <button @click="loadProducts" class="ml-4 underline">Réessayer</button>
      </div>

      <div class="card overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Produit</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Categorie</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Prix</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Stock</th>
              <th class="text-left p-4 text-sm font-medium text-gray-500">Statut</th>
              <th class="text-right p-4 text-sm font-medium text-gray-500">Actions</th>
            </tr>
          </thead>
          <tbody v-if="!loading && produits.length">
            <tr v-for="produit in produits" :key="produit.id" class="border-t">
              <td class="p-4">
                <div class="flex items-center gap-3">
                  <img :src="produit.image || '/placeholder-product.jpg'" class="w-10 h-10 object-cover rounded" />
                  <div>
                    <p class="font-medium text-sm">{{ produit.nom }}</p>
                    <p class="text-xs text-gray-500">{{ produit.marque?.nom }}</p>
                  </div>
                </div>
              </td>
              <td class="p-4 text-sm">{{ produit.category?.nom }}</td>
              <td class="p-4 text-sm font-medium">{{ produit.prix }} MAD</td>
              <td class="p-4 text-sm">
                <span :class="produit.stock <= 5 ? 'text-red-500 font-bold' : ''">{{ produit.stock }}</span>
              </td>
              <td class="p-4">
                <span class="badge" :class="produit.en_vedette ? 'badge-success' : 'badge-danger'">
                  {{ produit.en_vedette ? 'En vedette' : 'Standard' }}
                </span>
              </td>
              <td class="p-4 text-right">
                <router-link :to="`/admin/produits/${produit.id}/edit`" class="text-primary hover:underline text-sm">
                  Modifier
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
        <div v-if="loading" class="p-8 text-center text-gray-500">
          Chargement...
        </div>
        <div v-else-if="!produits.length && !error" class="p-8 text-center text-gray-500">
          Aucun produit trouve.
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import api from '@/services/api'

const authStore = useAuthStore()
const produits = ref([])
const loading = ref(true)
const error = ref(null)

async function loadProducts() {
  loading.value = true
  error.value = null
  
  try {
    const response = await api.get('/admin/produits')
    console.log('API Response:', response.data)
    // API returns array directly
    produits.value = response.data || []
  } catch (e) {
    console.error('Error loading products:', e.response?.data || e.message)
    if (e.response?.status === 401) {
      error.value = 'Non autorisé. Veuillez vous reconnecter.'
    } else {
      error.value = e.response?.data?.message || 'Erreur lors du chargement des produits'
    }
    produits.value = []
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  // Only load products if authenticated
  if (authStore.isAuthenticated) {
    loadProducts()
  } else {
    error.value = 'Veuillez vous connecter en tant qu\'administrateur.'
    loading.value = false
  }
})
</script>
