<template>
  <aside class="w-64 bg-secondary text-white min-h-screen p-4">
    <div class="mb-8">
      <h2 class="text-xl font-heading font-bold">
        <span class="text-primary">Wolf</span>Store Admin
      </h2>
    </div>

    <nav class="space-y-1">
      <router-link
        v-for="item in menuItems"
        :key="item.path"
        :to="item.path"
        class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors"
        :class="$route.path === item.path ? 'bg-primary' : 'hover:bg-secondary-600'"
      >
        <component :is="item.icon" class="h-5 w-5" />
        {{ item.label }}
      </router-link>
    </nav>

    <div class="mt-8 pt-8 border-t border-gray-600">
      <router-link to="/" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm hover:bg-secondary-600">
        <ArrowLeftOnRectangleIcon class="h-5 w-5" />
        Voir le site
      </router-link>
    </div>
  </aside>
</template>

<script setup>
import {
  ChartBarIcon,
  Squares2X2Icon,
  ShoppingBagIcon,
  ChatBubbleLeftRightIcon,
  ArrowLeftOnRectangleIcon,
} from '@heroicons/vue/24/outline'

const menuItems = [
  { path: '/admin', label: 'Dashboard', icon: ChartBarIcon },
  { path: '/admin/produits', label: 'Produits', icon: Squares2X2Icon },
  { path: '/admin/commandes', label: 'Commandes', icon: ShoppingBagIcon },
  { path: '/admin/avis', label: 'Avis', icon: ChatBubbleLeftRightIcon },
]
</script>
