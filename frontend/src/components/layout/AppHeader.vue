<template>
  <header class="glassmorphism sticky top-0 z-40">
    <div class="container-custom">
      <div class="flex items-center justify-between h-16 lg:h-20">
        <div class="flex items-center gap-4">
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden p-2 rounded-md text-text-secondary hover:text-text-primary transition-colors"
          >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>

          <router-link to="/" class="flex items-center gap-2 group">
            <span class="text-2xl font-display font-bold bg-gradient-to-r from-accent-primary via-accent-secondary to-accent-primary bg-clip-text text-transparent group-hover:animate-pulse-glow">🐺</span>
            <span class="text-2xl font-display font-bold bg-gradient-to-r from-accent-primary to-accent-secondary bg-clip-text text-transparent group-hover:opacity-80 transition-opacity">WolfStore</span>
          </router-link>
        </div>

        <nav class="hidden lg:flex items-center gap-8">
          <router-link to="/" class="nav-link">Accueil</router-link>
          <router-link to="/catalogue" class="nav-link">Catalogue</router-link>
        </nav>

        <div class="flex items-center gap-2">
           <button
             @click="$emit('open-wishlist')"
             class="relative p-2 text-text-secondary hover:text-accent transition-colors"
           >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            <span
              v-if="wishlistStore.count > 0"
              class="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold"
            >
              {{ wishlistStore.count }}
            </span>
          </button>

           <button
             @click="$emit('open-cart')"
             class="relative p-2 text-text-secondary hover:text-accent transition-colors"
           >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            <span
              v-if="cartStore.count > 0"
              class="absolute -top-1 -right-1 bg-accent text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-glow"
            >
              {{ cartStore.count }}
            </span>
          </button>

          <button
            @click="toggleTheme"
            class="p-2 text-text-secondary hover:text-accent transition-colors"
            :title="isLightMode ? 'Activer le mode sombre' : 'Activer le mode clair'"
            :aria-label="isLightMode ? 'Activer le mode sombre' : 'Activer le mode clair'"
          >
            <svg v-if="isLightMode" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 16c-5.385 0-9.75-4.365-9.75-9.75 0-1.313.26-2.564.732-3.705A9.75 9.75 0 1021.752 15.002z" />
            </svg>
            <svg v-else class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2.25M12 18.75V21M4.5 12H2.25M21.75 12H19.5M5.636 5.636l1.591 1.591M16.773 16.773l1.591 1.591M5.636 18.364l1.591-1.591M16.773 7.227l1.591-1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
          </button>

          <div class="relative">
            <button
              @click="userMenuOpen = !userMenuOpen"
              class="p-2 text-text-secondary hover:text-accent transition-colors"
            >
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </button>

            <div
              v-if="userMenuOpen"
              class="absolute right-0 mt-2 w-48 bg-bg-card border border-border rounded-lg shadow-lg py-1 z-50"
            >
              <template v-if="authStore.isAuthenticated">
                <router-link
                  to="/compte"
                  class="block px-4 py-2 text-sm text-text-primary hover:bg-bg-hover transition-colors"
                  @click="userMenuOpen = false"
                >
                  Mon Compte
                </router-link>
                <router-link
                  v-if="authStore.isAdmin"
                  to="/admin"
                  class="block px-4 py-2 text-sm text-text-primary hover:bg-bg-hover transition-colors"
                  @click="userMenuOpen = false"
                >
                  Administration
                </router-link>
                <button
                  @click="handleLogout"
                  class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-bg-hover transition-colors"
                >
                  Déconnexion
                </button>
              </template>
              <template v-else>
                <router-link
                  to="/connexion"
                  class="block px-4 py-2 text-sm text-text-primary hover:bg-bg-hover transition-colors"
                  @click="userMenuOpen = false"
                >
                  Connexion
                </router-link>
                <router-link
                  to="/inscription"
                  class="block px-4 py-2 text-sm text-accent font-medium hover:bg-bg-hover transition-colors"
                  @click="userMenuOpen = false"
                >
                  Inscription
                </router-link>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="mobileMenuOpen"
      class="lg:hidden bg-bg-secondary border-t border-border"
    >
      <div class="container-custom py-4 space-y-2">
        <router-link to="/" class="block px-4 py-2 rounded-md text-text-primary hover:bg-bg-hover transition-colors" @click="mobileMenuOpen = false">Accueil</router-link>
        <router-link to="/catalogue" class="block px-4 py-2 rounded-md text-text-primary hover:bg-bg-hover transition-colors" @click="mobileMenuOpen = false">Catalogue</router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useCartStore } from '@/stores/cart'
import { useWishlistStore } from '@/stores/wishlist'

const authStore = useAuthStore()
const cartStore = useCartStore()
const wishlistStore = useWishlistStore()

const mobileMenuOpen = ref(false)
const userMenuOpen = ref(false)
const isLightMode = ref(false)

defineEmits(['open-cart', 'open-wishlist'])

const handleLogout = async () => {
  await authStore.logout()
  userMenuOpen.value = false
  router.push('/')
}

function applyTheme(lightMode) {
  document.documentElement.classList.toggle('theme-light', lightMode)
  localStorage.setItem('theme', lightMode ? 'light' : 'dark')
  isLightMode.value = lightMode
}

function toggleTheme() {
  applyTheme(!isLightMode.value)
}

function closeMenuOnOutsideClick(e) {
  if (!e.target.closest('.relative')) {
    userMenuOpen.value = false
  }
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme')
  applyTheme(savedTheme === 'light')
  document.addEventListener('click', closeMenuOnOutsideClick)
})

onUnmounted(() => {
  document.removeEventListener('click', closeMenuOnOutsideClick)
})
</script>

<style scoped>
.nav-link {
  @apply text-text-secondary hover:text-accent font-medium transition-colors relative;
}

.nav-link.router-link-active {
  @apply text-accent;
}

.nav-link.router-link-active::after {
  content: '';
  @apply absolute bottom-0 left-0 right-0 h-0.5 bg-accent;
}
</style>
