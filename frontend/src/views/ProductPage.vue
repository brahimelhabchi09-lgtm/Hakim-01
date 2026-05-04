<template>
  <div v-if="loading" class="container-custom py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="aspect-square bg-bg-secondary rounded-xl animate-pulse" />
      <div class="space-y-4">
        <div class="h-8 bg-bg-secondary rounded w-3/4 animate-pulse" />
        <div class="h-4 bg-bg-secondary rounded w-1/3 animate-pulse" />
        <div class="h-4 bg-bg-secondary rounded w-full animate-pulse" />
        <div class="h-4 bg-bg-secondary rounded w-2/3 animate-pulse" />
      </div>
    </div>
  </div>

  <div v-else-if="produit" class="bg-bg-primary">
    <div class="container-custom py-8">
      <!-- Breadcrumb -->
      <nav class="text-sm text-text-muted mb-6 flex items-center gap-2">
        <router-link to="/" class="hover:text-accent transition-colors">Accueil</router-link>
        <span>/</span>
        <router-link to="/catalogue" class="hover:text-accent transition-colors">Catalogue</router-link>
        <span>/</span>
        <span class="text-text-secondary">{{ produit.nom }}</span>
      </nav>

      <!-- Product Details -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <ProductGallery :produit="produit" />
        <ProductInfo
          :produit="produit"
          :isAdding="adding"
          @add-to-cart="handleAddToCart"
        />
      </div>

      <!-- Reviews -->
      <div class="mt-12 border-t border-border pt-12">
        <ProductReviews
          :produit-id="produit.id"
          :reviews="produit.avis || []"
          @review-added="loadProduct"
        />
      </div>

      <!-- Related Products -->
      <div class="mt-12 border-t border-border pt-12">
        <h2 class="section-title mb-6">Produits Similaires</h2>
        <RelatedProducts :produits="relatedProducts" />
      </div>
    </div>
  </div>

  <div v-else class="container-custom py-8 text-center">
    <div class="text-6xl mb-4">📦</div>
    <p class="text-text-secondary text-lg">Produit non trouve.</p>
    <router-link to="/catalogue" class="text-accent hover:underline mt-2 inline-block">
      Retour au catalogue
    </router-link>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import { useToast } from '@/composables/useToast'
import { useCart } from '@/composables/useCart'
import ProductGallery from '@/components/product/ProductGallery.vue'
import ProductInfo from '@/components/product/ProductInfo.vue'
import ProductReviews from '@/components/product/ProductReviews.vue'
import RelatedProducts from '@/components/product/RelatedProducts.vue'

const route = useRoute()
const productsStore = useProductsStore()
const { success, error } = useToast()
const { addToCart } = useCart()

const produit = ref(null)
const relatedProducts = ref([])
const loading = ref(true)
const adding = ref(false)

onMounted(async () => {
  await loadProduct()
})

watch(() => route.params.slug, loadProduct)

async function loadProduct() {
  loading.value = true
  try {
    await productsStore.fetchProduit(route.params.slug)
    produit.value = productsStore.produit
    if (produit.value) {
      relatedProducts.value = await productsStore.fetchRelated(produit.value.id)
    }
  } catch (err) {
    produit.value = null
  } finally {
    loading.value = false
  }
}

async function handleAddToCart(produitId, qty = 1) {
  adding.value = true
  try {
    const result = await addToCart(produitId, qty)
    if (result.success) {
      success('Produit ajoute au panier')
    } else {
      error(result.message)
    }
  } finally {
    adding.value = false
  }
}
</script>
