import { defineStore } from 'pinia'
import api from '@/services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token') || null,
    loading: false,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    isAdmin: (state) => state.user?.role === 'admin',
    userName: (state) => state.user ? `${state.user.prenom} ${state.user.nom}` : '',
  },

  actions: {
    async register(data) {
      try {
        const response = await api.post('/auth/register', data)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        return { success: true }
      } catch (error) {
        return {
          success: false,
          errors: error.response?.data?.errors || { message: error.response?.data?.message },
        }
      }
    },

    async login(data) {
      try {
        const response = await api.post('/auth/login', data)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        return { success: true }
      } catch (error) {
        return {
          success: false,
          errors: error.response?.data?.errors || { message: error.response?.data?.message },
        }
      }
    },

    async logout() {
      try {
        await api.post('/auth/logout')
      } catch {
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
      }
    },

    async fetchUser() {
      if (!this.token) return
      try {
        const response = await api.get('/auth/user')
        this.user = response.data.user
      } catch {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
      }
    },

    async forgotPassword(email) {
      try {
        await api.post('/auth/forgot-password', { email })
        return { success: true }
      } catch (error) {
        return {
          success: false,
          message: error.response?.data?.message,
        }
      }
    },

    async resetPassword(data) {
      try {
        await api.post('/auth/reset-password', data)
        return { success: true }
      } catch (error) {
        return {
          success: false,
          errors: error.response?.data?.errors || { message: error.response?.data?.message },
        }
      }
    },
  },
})
