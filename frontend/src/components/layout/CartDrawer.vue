<template>
  <Teleport to="body">
    <transition name="slide">
       <div v-if="modelValue" class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-bg-primary/80 backdrop-blur-sm" @click="close" />

        <div class="absolute right-0 top-0 h-full w-full max-w-md bg-bg-secondary shadow-2xl flex flex-col">
          <!-- Header -->
          <div class="flex items-center justify-between p-4 border-b border-border">
            <h2 class="text-lg font-display font-bold text-text-primary">
              Panier ({{ cartStore.count }})
            </h2>
            <button @click="close" class="p-2 text-text-secondary hover:text-text-primary transition-colors">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <!-- Empty State -->
          <div v-if="cartStore.isEmpty" class="flex-1 flex items-center justify-center">
            <div class="text-center text-text-secondary">
              <svg class="h-16 w-16 mx-auto mb-4 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
              <p class="font-medium">Votre panier est vide</p>
              <router-link
                to="/catalogue"
                @click="close"
                class="text-accent hover:underline mt-2 inline-block"
              >
                Continuer les achats
              </router-link>
            </div>
          </div>

          <!-- Cart Items -->
          <div v-else class="flex-1 overflow-y-auto p-4 space-y-4">
            <div
              v-for="item in cartStore.items"
              :key="item.row_id"
              class="flex gap-4 bg-bg-card rounded-lg p-3 border border-border hover:border-border-light transition-colors"
            >
              <img
                :src="item.produit?.image || '/placeholder-product.jpg'"
                :alt="item.produit?.nom"
                class="w-20 h-20 object-cover rounded-md"
                loading="lazy"
              />
              <div class="flex-1 min-w-0">
                <router-link
                  :to="`/produit/${item.produit?.slug}`"
                  class="font-medium text-sm text-text-primary truncate hover:text-accent block"
                  @click="close"
                >
                  {{ item.produit?.nom }}
                </router-link>
                <p class="text-accent font-bold mt-1 text-sm">
                  {{ item.produit?.prix_promotionnel || item.produit?.prix }} MAD
                </p>
                <div class="flex items-center gap-2 mt-2">
                  <button
                    @click="updateQty(item.row_id, item.quantite - 1)"
                    class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-bg-hover transition-colors"
                    :disabled="item.quantite <= 1"
                  >
                    <svg class="h-3 w-3 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                  </button>
                  <span class="text-sm font-medium w-6 text-center text-text-primary">{{ item.quantite }}</span>
                  <button
                    @click="updateQty(item.row_id, item.quantite + 1)"
                    class="w-7 h-7 rounded-full border border-border flex items-center justify-center hover:bg-bg-hover transition-colors"
                  >
                    <svg class="h-3 w-3 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                  </button>
                  <button
                    @click="removeItem(item.row_id)"
                    class="ml-auto text-text-muted hover:text-red-500 transition-colors"
                  >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Footer with Totals -->
          <div v-if="!cartStore.isEmpty" class="border-t border-border p-4 space-y-4">
            <div class="space-y-2 text-sm">
              <div class="flex justify-between text-text-secondary">
                <span>Sous-total</span>
                <span>{{ cartStore.subtotal.toFixed(2) }} MAD</span>
              </div>
              <div class="flex justify-between text-text-secondary">
                <span>Livraison</span>
                <span>{{ cartStore.shipping.toFixed(2) }} MAD</span>
              </div>
              <div class="flex justify-between font-bold text-lg pt-2 border-t border-border text-text-primary">
                <span>Total</span>
                <span class="text-accent">{{ cartStore.grandTotal.toFixed(2) }} MAD</span>
              </div>
            </div>

            <div class="flex gap-2">
              <router-link
                to="/panier"
                @click="close"
                class="btn-secondary flex-1 text-center"
              >
                Voir le panier
              </router-link>
              <router-link
                to="/checkout"
                @click="close"
                class="btn-primary flex-1 text-center gradient-accent border-0"
              >
                Commander
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { watch } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useCart } from '@/composables/useCart'

const router = useRouter()
const cartStore = useCartStore()
const { updateQuantity, removeItem } = useCart()

const props = defineProps({
  modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue'])

watch(() => props.modelValue, (val) => {
  if (val) {
    cartStore.fetchCart()
  }
})

function close() {
  emit('update:modelValue', false)
}

async function updateQty(rowId, qty) {
  if (qty < 1) return
  await updateQuantity(rowId, qty)
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
