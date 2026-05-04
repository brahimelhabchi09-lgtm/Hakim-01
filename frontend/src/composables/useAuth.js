import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'

export function useAuth() {
  const authStore = useAuthStore()

  const user = computed(() => authStore.user)
  const isAuthenticated = computed(() => authStore.isAuthenticated)
  const isAdmin = computed(() => authStore.isAdmin)
  const userName = computed(() => authStore.userName)
  const loading = computed(() => authStore.loading)

  async function login(data) {
    return await authStore.login(data)
  }

  async function register(data) {
    return await authStore.register(data)
  }

  async function logout() {
    await authStore.logout()
  }

  return {
    user,
    isAuthenticated,
    isAdmin,
    userName,
    loading,
    login,
    register,
    logout,
  }
}
