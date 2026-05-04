import { defineStore } from 'pinia'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useWishlistStore = defineStore('wishlist', {
  state: () => ({
    produits: [],
    count: 0,
    loading: false,
  }),

  getters: {
    isEmpty: (state) => state.produits.length === 0,
    isInWishlist: (state) => (produitId) => {
      return state.produits.some((p) => p.id === produitId)
    },
  },

  actions: {
    async fetchWishlist() {
      try {
        const response = await api.get('/wishlist')
        this.produits = response.data.produits
        this.count = response.data.count
      } catch (error) {
        console.error('Failed to fetch wishlist:', error)
      }
    },

    async addToWishlist(produitId) {
      const authStore = useAuthStore()
      if (!authStore.isAuthenticated) {
        const localWishlist = JSON.parse(localStorage.getItem('wishlist') || '[]')
        if (!localWishlist.includes(produitId)) {
          localWishlist.push(produitId)
          localStorage.setItem('wishlist', JSON.stringify(localWishlist))
        }
        return { success: true }
      }

      try {
        await api.post('/wishlist/ajouter', { produit_id: produitId })
        await this.fetchWishlist()
        return { success: true }
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message || 'Erreur lors de l\'ajout aux favoris',
        }
      }
    },

    async removeFromWishlist(produitId) {
      const authStore = useAuthStore()
      if (!authStore.isAuthenticated) {
        const localWishlist = JSON.parse(localStorage.getItem('wishlist') || '[]')
        const updated = localWishlist.filter((id) => id !== produitId)
        localStorage.setItem('wishlist', JSON.stringify(updated))
        this.produits = this.produits.filter((p) => p.id !== produitId)
        this.count = this.produits.length
        return
      }

      try {
        await api.delete(`/wishlist/${produitId}`)
        await this.fetchWishlist()
      } catch (error) {
        console.error('Failed to remove from wishlist:', error)
      }
    },
  },
})
