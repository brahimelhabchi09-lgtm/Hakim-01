import { ref } from 'vue'
import { useCartStore } from '@/stores/cart'

export function useCart() {
  const cartStore = useCartStore()
  const isAdding = ref({})

  async function addToCart(produitId, quantite = 1) {
    isAdding.value = { ...isAdding.value, [produitId]: true }
    try {
      const result = await cartStore.addToCart(produitId, quantite)
      return result
    } finally {
      isAdding.value = { ...isAdding.value, [produitId]: false }
    }
  }

  async function updateQuantity(rowId, quantite) {
    return await cartStore.updateQuantity(rowId, quantite)
  }

  async function removeItem(rowId) {
    return await cartStore.removeItem(rowId)
  }

  return {
    cartStore,
    isAdding,
    addToCart,
    updateQuantity,
    removeItem,
  }
}
