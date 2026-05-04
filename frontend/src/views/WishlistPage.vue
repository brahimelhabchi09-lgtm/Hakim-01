<template>
  <div class="container-custom py-8">
    <h1 class="text-2xl font-heading font-bold mb-8">Ma Wishlist</h1>

    <div v-if="wishlistStore.isEmpty" class="text-center py-12">
      <HeartIcon class="h-16 w-16 mx-auto mb-4 text-gray-300" />
      <p class="text-gray-500 text-lg mb-4">Votre wishlist est vide</p>
      <router-link to="/catalogue" class="btn-primary">
        Decouvrir nos produits
      </router-link>
    </div>

    <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <ProductCard
        v-for="produit in wishlistStore.produits"
        :key="produit.id"
        :produit="produit"
        @add-to-cart="handleAddToCart"
      />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useWishlistStore } from '@/stores/wishlist'
import { useToast } from '@/composables/useToast'
import { useCart } from '@/composables/useCart'
import ProductCard from '@/components/ui/ProductCard.vue'
import { HeartIcon } from '@heroicons/vue/24/outline'

const wishlistStore = useWishlistStore()
const { success, error } = useToast()
const { addToCart } = useCart()

onMounted(() => {
  wishlistStore.fetchWishlist()
})

async function handleAddToCart(produitId) {
  const result = await addToCart(produitId)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>
