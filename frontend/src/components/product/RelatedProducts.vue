<template>
  <section v-if="produits.length > 0" class="mt-12">
    <h2 class="text-2xl font-heading font-bold text-secondary mb-6">Produits apparentés</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <ProductCard
        v-for="produit in produits"
        :key="produit.id"
        :produit="produit"
        @add-to-cart="handleAddToCart"
      />
    </div>
  </section>
</template>

<script setup>
import { useToast } from '@/composables/useToast'
import { useCart } from '@/composables/useCart'
import ProductCard from '@/components/ui/ProductCard.vue'

defineProps({
  produits: { type: Array, default: () => [] },
})

const { success, error } = useToast()
const { cartStore, addToCart, isAdding } = useCart()

async function handleAddToCart(produitId) {
  const result = await addToCart(produitId)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>
