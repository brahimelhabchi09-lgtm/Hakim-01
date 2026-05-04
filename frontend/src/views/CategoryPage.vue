<template>
  <div v-if="loading" class="container-custom py-8">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
      <ProductCardSkeleton v-for="i in 6" :key="i" />
    </div>
  </div>

  <div v-else-if="category" class="container-custom py-8">
    <nav class="text-sm text-gray-500 mb-4">
      <router-link to="/" class="hover:text-primary">Accueil</router-link>
      /
      <router-link to="/catalogue" class="hover:text-primary">Catalogue</router-link>
      /
      <span class="text-secondary">{{ category.nom }}</span>
    </nav>

    <h1 class="text-3xl font-heading font-bold text-secondary mb-2">{{ category.nom }}</h1>
    <p v-if="category.description" class="text-gray-600 mb-8">{{ category.description }}</p>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <ProductCard
        v-for="produit in produits"
        :key="produit.id"
        :produit="produit"
        @add-to-cart="handleAddToCart"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
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

const category = ref(null)
const produits = ref([])
const loading = ref(true)

onMounted(async () => {
  await loadCategory()
})

watch(() => route.params.slug, loadCategory)

async function loadCategory() {
  loading.value = true
  try {
    const result = await productsStore.fetchCategoryProduits(route.params.slug)
    category.value = result.category
    produits.value = result.produits
  } catch (error) {
    category.value = null
    produits.value = []
  } finally {
    loading.value = false
  }
}

async function handleAddToCart(produitId) {
  const result = await addToCart(produitId)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>
