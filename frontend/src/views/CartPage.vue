<template>
  <div class="container-custom py-8">
    <h1 class="text-2xl font-heading font-bold mb-8">Mon Panier</h1>

    <div v-if="cartStore.isEmpty" class="text-center py-12">
      <ShoppingCartIcon class="h-16 w-16 mx-auto mb-4 text-gray-300" />
      <p class="text-gray-500 text-lg mb-4">Votre panier est vide</p>
      <router-link to="/catalogue" class="btn-primary">
        Continuer les achats
      </router-link>
    </div>

    <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-4">
        <CartItem
          v-for="item in cartStore.items"
          :key="item.row_id"
          :item="item"
          @update-qty="handleUpdateQty"
          @remove="handleRemove"
        />

        <button
          @click="cartStore.clearCart()"
          class="text-red-500 hover:text-red-600 text-sm"
        >
          Vider le panier
        </button>
      </div>

      <CartSummary
        :subtotal="cartStore.subtotal"
        :shipping="cartStore.shipping"
      >
        <router-link to="/checkout" class="btn-primary w-full text-center mt-4">
          Passer la commande
        </router-link>
      </CartSummary>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useCartStore } from '@/stores/cart'
import { useCart } from '@/composables/useCart'
import { useToast } from '@/composables/useToast'
import CartItem from '@/components/cart/CartItem.vue'
import CartSummary from '@/components/cart/CartSummary.vue'
import { ShoppingCartIcon } from '@heroicons/vue/24/outline'

const cartStore = useCartStore()
const { updateQuantity, removeItem } = useCart()
const { success, error } = useToast()

onMounted(() => {
  cartStore.fetchCart()
})

async function handleUpdateQty(rowId, qty) {
  if (qty < 1) return
  const result = await updateQuantity(rowId, qty)
  if (!result?.success && result) {
    error(result.message)
  }
}

async function handleRemove(rowId) {
  await removeItem(rowId)
  success('Article supprime du panier')
}
</script>
