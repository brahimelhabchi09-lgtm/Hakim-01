<template>
  <div class="bg-bg-primary min-h-screen">
    <div class="container-custom py-8">
      <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
        <div>
          <h1 class="text-2xl lg:text-3xl font-display font-bold text-text-primary">Catalogue</h1>
          <p class="text-text-secondary mt-1">{{ productsStore.totalProduits || 0 }} produit(s) trouve(s)</p>
        </div>
      </div>

      <div class="flex gap-8">
        <!-- Products Grid -->
        <div class="flex-1">
          <div v-if="productsStore.loading" class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <ProductCardSkeleton v-for="i in 6" :key="i" />
          </div>

          <div
            v-else-if="productsStore.produits.length === 0"
            class="text-center py-12"
          >
            <div class="text-6xl mb-4">🔍</div>
            <p class="text-text-secondary text-lg">Aucun produit trouve.</p>
          </div>

          <div v-else class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <ProductCard
              v-for="produit in productsStore.produits"
              :key="produit.id"
              :produit="produit"
              @add-to-cart="handleAddToCart"
            />
          </div>

          <!-- Pagination -->
          <div v-if="productsStore.totalPages > 1" class="flex justify-center gap-2 mt-8">
            <button
              v-for="p in productsStore.totalPages"
              :key="p"
              @click="goToPage(p)"
              class="w-10 h-10 rounded-lg border transition-all duration-fast text-sm font-medium"
              :class="p === productsStore.pagination.current_page 
                ? 'bg-accent border-accent text-white shadow-glow' 
                : 'border-border text-text-secondary hover:bg-bg-hover hover:border-border-light'"
            >
              {{ p }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import { useToast } from '@/composables/useToast'
import { useCart } from '@/composables/useCart'
import ProductCard from '@/components/ui/ProductCard.vue'
import ProductCardSkeleton from '@/components/ui/ProductCardSkeleton.vue'

const route = useRoute()
const productsStore = useProductsStore()
const { success, error } = useToast()
const { addToCart } = useCart()

const page = ref(1)

watch(
  () => route.query,
  () => {
    applyFilters()
  },
  { immediate: true }
)

onMounted(() => {
  applyFilters()
})

function applyFilters() {
  const params = {
    page: page.value,
  }

  productsStore.fetchProduits(params)
}

function goToPage(p) {
  page.value = p
  applyFilters()
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

async function handleAddToCart(product) {
  const produitId = Number(typeof product === 'object' ? product?.id : product)
  if (!produitId) return
  const result = await addToCart(produitId)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>
