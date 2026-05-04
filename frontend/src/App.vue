<template>
  <div class="min-h-screen flex flex-col bg-gradient-to-br from-bg-primary via-bg-secondary to-bg-primary">
    <AppHeader
      @open-cart="cartDrawerOpen = true"
      @open-wishlist="wishlistDrawerOpen = true"
    />
    <main class="flex-grow">
      <router-view v-slot="{ Component }">
        <transition name="fade-scale" mode="out-in">
          <component :is="Component" class="animate-fade-slide-up" />
        </transition>
      </router-view>
    </main>
    <AppFooter />
    <CartDrawer v-model="cartDrawerOpen" />
    <WishlistDrawer v-model="wishlistDrawerOpen" />
    <ToastNotification />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AppHeader from '@/components/layout/AppHeader.vue'
import AppFooter from '@/components/layout/AppFooter.vue'
import CartDrawer from '@/components/layout/CartDrawer.vue'
import WishlistDrawer from '@/components/layout/WishlistDrawer.vue'
import ToastNotification from '@/components/ui/ToastNotification.vue'

const cartDrawerOpen = ref(false)
const wishlistDrawerOpen = ref(false)
</script>

<style scoped>
.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}

.fade-scale-enter-from {
  opacity: 0;
  transform: scale(0.98);
}

.fade-scale-leave-to {
  opacity: 0;
  transform: scale(1.02);
}

/* Smooth background animation */
@keyframes gradientShift {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
</style>
