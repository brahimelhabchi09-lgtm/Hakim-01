import { defineStore } from 'pinia'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useCartStore = defineStore('cart', {
  state: () => ({
    items: [],
    total: 0,
    count: 0,
    loading: false,
  }),

  getters: {
    isEmpty: (state) => state.items.length === 0,
    subtotal: (state) => state.total,
    shipping: (state) => state.count > 0 ? 40 : 0,
    grandTotal: (state) => state.total + state.shipping,
  },

  actions: {
    async fetchCart() {
      try {
        const response = await api.get('/panier')
        this.items = response.data.items
        this.total = response.data.total
        this.count = response.data.count
      } catch (error) {
        console.error('Failed to fetch cart:', error)
      }
    },

    async addToCart(produitId, quantite = 1) {
      this.loading = true
      try {
        const response = await api.post('/panier/ajouter', { produit_id: parseInt(produitId, 10), quantite })
        this.items = response.data.items
        this.total = response.data.total
        this.count = response.data.count
        return { success: true }
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message || 'Erreur lors de l\'ajout au panier',
        }
      } finally {
        this.loading = false
      }
    },

    async updateQuantity(rowId, quantite) {
      try {
        const response = await api.put(`/panier/${rowId}`, { quantite })
        this.items = response.data.items
        this.total = response.data.total
        this.count = response.data.count
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message || 'Erreur lors de la modification',
        }
      }
    },

    async removeItem(rowId) {
      try {
        const response = await api.delete(`/panier/${rowId}`)
        this.items = response.data.items
        this.total = response.data.total
        this.count = response.data.count
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message || 'Erreur lors de la suppression',
        }
      }
    },

    async clearCart() {
      try {
        await api.delete('/panier/vider')
        this.items = []
        this.total = 0
        this.count = 0
      } catch (error) {
        console.error('Failed to clear cart:', error)
      }
    },
  },
})
