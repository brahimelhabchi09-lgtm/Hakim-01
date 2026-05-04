import { defineStore } from 'pinia'
import api from '@/services/api'

export const useProductsStore = defineStore('products', {
  state: () => ({
    produits: [],
    produit: null,
    categories: [],
    marques: [],
    pagination: {
      current_page: 1,
      last_page: 1,
      per_page: 12,
      total: 0,
    },
    filters: {
      categories: [],
      marques: [],
    },
    loading: false,
  }),

  getters: {
    totalPages: (state) => state.pagination.last_page,
    totalProduits: (state) => state.pagination.total,
  },

  actions: {
    async fetchProduits(params = {}) {
      this.loading = true
      try {
        const response = await api.get('/produits', { params })
        this.produits = response.data.data
        this.pagination = {
          current_page: response.data.meta.current_page,
          last_page: response.data.meta.last_page,
          per_page: response.data.meta.per_page,
          total: response.data.meta.total,
        }
        if (response.data.filters) {
          this.filters = response.data.filters
        }
      } catch (error) {
        console.error('Failed to fetch products:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchFeatured() {
      try {
        const response = await api.get('/produits/en-vedette')
        return response.data.produits
      } catch (error) {
        console.error('Failed to fetch featured products:', error)
        return []
      }
    },

    async fetchProduit(slug) {
      this.loading = true
      try {
        const response = await api.get(`/produits/${slug}`)
        this.produit = response.data.produit
      } catch (error) {
        this.produit = null
        throw error
      } finally {
        this.loading = false
      }
    },

    async fetchRelated(id) {
      try {
        const response = await api.get(`/produits/apparentes/${id}`)
        return response.data.produits
      } catch (error) {
        console.error('Failed to fetch related products:', error)
        return []
      }
    },

    async fetchCategories() {
      try {
        const response = await api.get('/categories')
        this.categories = response.data.categories
      } catch (error) {
        console.error('Failed to fetch categories:', error)
      }
    },

    async fetchMarques() {
      try {
        const response = await api.get('/marques')
        this.marques = response.data.marques
      } catch (error) {
        console.error('Failed to fetch brands:', error)
      }
    },

    async fetchCategoryProduits(slug, params = {}) {
      this.loading = true
      try {
        const response = await api.get(`/categories/${slug}`, { params })
        return {
          category: response.data.category,
          produits: response.data.produits.data,
          pagination: {
            current_page: response.data.produits.meta.current_page,
            last_page: response.data.produits.meta.last_page,
            per_page: response.data.produits.meta.per_page,
            total: response.data.produits.meta.total,
          },
        }
      } catch (error) {
        throw error
      } finally {
        this.loading = false
      }
    },

    async addReview(produitId, data) {
      try {
        await api.post(`/produits/${produitId}/avis`, data)
        return { success: true }
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message || 'Erreur lors de l\'ajout de l\'avis',
        }
      }
    },
  },
})
