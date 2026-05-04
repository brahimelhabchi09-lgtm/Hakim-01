import { ref } from 'vue'
import { useWishlistStore } from '@/stores/wishlist'

export function useWishlist() {
  const wishlistStore = useWishlistStore()
  const isToggling = ref({})

  async function toggleWishlist(produitId) {
    isToggling.value[produitId] = true
    try {
      if (wishlistStore.isInWishlist(produitId)) {
        await wishlistStore.removeFromWishlist(produitId)
        return { action: 'removed' }
      } else {
        const result = await wishlistStore.addToWishlist(produitId)
        return result.success ? { action: 'added' } : result
      }
    } finally {
      isToggling.value[produitId] = false
    }
  }

  return {
    wishlistStore,
    isToggling,
    toggleWishlist,
  }
}
