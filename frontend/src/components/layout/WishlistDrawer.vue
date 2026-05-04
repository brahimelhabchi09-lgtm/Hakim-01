<template>
  <Teleport to="body">
    <transition name="slide">
      <div v-if="modelValue" class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-bg-primary/80 backdrop-blur-sm" @click="close" />

        <div class="absolute right-0 top-0 h-full w-full max-w-md bg-bg-secondary shadow-2xl flex flex-col">
          <!-- Header -->
          <div class="flex items-center justify-between p-4 border-b border-border">
            <h2 class="text-lg font-display font-bold text-text-primary">
              Favoris ({{ wishlistStore.count }})
            </h2>
            <button @click="close" class="p-2 text-text-secondary hover:text-text-primary transition-colors">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <!-- Empty State -->
          <div v-if="wishlistStore.isEmpty" class="flex-1 flex items-center justify-center">
            <div class="text-center text-text-secondary">
              <svg class="h-16 w-16 mx-auto mb-4 text-text-muted" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
              <p class="font-medium">Votre wishlist est vide</p>
              <router-link
                to="/catalogue"
                @click="close"
                class="text-accent hover:underline mt-2 inline-block"
              >
                Découvrir nos produits
              </router-link>
            </div>
          </div>

          <!-- Wishlist Items -->
          <div v-else class="flex-1 overflow-y-auto p-4 space-y-4">
            <div
              v-for="produit in wishlistStore.produits"
              :key="produit.id"
              class="flex gap-4 bg-bg-card rounded-lg p-3 border border-border hover:border-border-light transition-colors"
            >
              <img
                :src="produit.image || '/placeholder-product.jpg'"
                :alt="produit.nom"
                class="w-20 h-20 object-cover rounded-md"
                loading="lazy"
              />
              <div class="flex-1 min-w-0">
                <router-link
                  :to="`/produit/${produit.slug}`"
                  class="font-medium text-sm text-text-primary truncate hover:text-accent block"
                  @click="close"
                >
                  {{ produit.nom }}
                </router-link>
                <p class="text-accent font-bold mt-1 text-sm">
                  {{ produit.prix_promotionnel || produit.prix }} MAD
                </p>
                <div class="flex items-center gap-2 mt-2">
                  <button
                    @click="handleAddToCart(produit)"
                    class="text-xs bg-accent text-white px-3 py-1 rounded hover:bg-accent/80 transition-colors"
                  >
                    Ajouter au panier
                  </button>
                  <button
                    @click="removeFromWishlist(produit.id)"
                    class="ml-auto text-text-muted hover:text-red-500 transition-colors"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div v-if="!wishlistStore.isEmpty" class="border-t border-border p-4">
            <router-link
              to="/wishlist"
              @click="close"
              class="btn-secondary w-full text-center"
            >
              Voir toute la wishlist
            </router-link>
          </div>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { watch } from 'vue'
import { useRouter } from 'vue-router'
import { useWishlistStore } from '@/stores/wishlist'
import { useCart } from '@/composables/useCart'
import { useToast } from '@/composables/useToast'

const props = defineProps({
  modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const router = useRouter()
const wishlistStore = useWishlistStore()
const { addToCart } = useCart()
const { success, error } = useToast()

watch(() => props.modelValue, (val) => {
  if (val) {
    wishlistStore.fetchWishlist()
  }
})

function close() {
  emit('update:modelValue', false)
}

async function removeFromWishlist(produitId) {
  await wishlistStore.removeFromWishlist(produitId)
}

async function handleAddToCart(produit) {
  const result = await addToCart(produit.id, 1)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(100%);
}
</style>
