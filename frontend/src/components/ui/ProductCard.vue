<template>
  <div class="card group hover-scale transform-gpu transition-all duration-normal hover:shadow-glow-cyan">
    <router-link :to="`/produit/${produit.slug}`" class="relative block">
      <div class="aspect-square overflow-hidden bg-bg-secondary rounded-lg relative">
        <img
          :src="produit.image || '/placeholder-product.jpg'"
          :alt="produit.nom"
          class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-slow"
          loading="lazy"
        />
        <!-- Shimmer effect overlay -->
        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-normal bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></div>
        
        <!-- Overlay with quick actions -->
        <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-normal flex items-end justify-center gap-2 pb-4">
          <button class="p-2 bg-bg-card rounded-full hover:bg-accent hover:text-white transition-all duration-fast transform hover:scale-110 hover:shadow-glow" title="Voir">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
          <button @click.prevent="toggleWishlist(produit.id)" class="p-2 bg-bg-card rounded-full hover:bg-accent hover:text-white transition-all duration-fast transform hover:scale-110 hover:shadow-glow" title="Wishlist">
            <svg class="w-5 h-5" :class="wishlistStore.isInWishlist(produit.id) ? 'text-red-500 fill-red-500 animate-pulse' : 'text-text-primary'" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
          </button>
        </div>
      </div>

      <!-- Badges with animations -->
      <div class="absolute top-2 left-2 flex flex-col gap-1">
        <span v-if="produit.en_vedette" class="px-2 py-1 text-xs font-bold bg-gradient-to-r from-accent-primary to-accent-secondary text-white rounded shadow-glow animate-pulse">
          EN VEDETTE
        </span>
        <span v-if="produit.prix_promotionnel" class="px-2 py-1 text-xs font-bold bg-red-600 text-white rounded animate-pulse">
          -{{ Math.round((1 - produit.prix_promotionnel / produit.prix) * 100) }}%
        </span>
      </div>
    </router-link>

    <div class="p-4">
      <router-link :to="`/produit/${produit.slug}`" class="block">
        <div v-if="produit.marque" class="text-xs text-accent-secondary uppercase tracking-wide mb-1 font-semibold">
          {{ produit.marque.nom }}
        </div>
        <h3 class="font-medium text-sm text-text-primary line-clamp-2 hover:text-accent-primary transition-colors duration-fast group/title">
          {{ produit.nom }}
        </h3>
      </router-link>

      <!-- Rating -->
      <div class="flex items-center gap-1 mt-2">
        <div class="flex text-accent-secondary">
          <svg v-for="i in 5" :key="i" class="w-4 h-4 transition-transform duration-fast hover:scale-110" :class="i <= Math.round(produit.avis_moyenne || 0) ? 'fill-current' : 'fill-gray-700'" viewBox="0 0 20 20">
            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
          </svg>
        </div>
        <span class="text-xs text-text-secondary ml-1">({{ produit.avis_total || 0 }})</span>
      </div>

      <!-- Price with animation -->
      <div class="mt-3 flex items-center gap-2">
        <span v-if="produit.prix_promotionnel" class="text-lg font-bold bg-gradient-to-r from-accent-primary to-accent-secondary bg-clip-text text-transparent">
          {{ produit.prix_promotionnel }} MAD
        </span>
        <span v-if="produit.prix_promotionnel" class="text-sm text-text-muted line-through">
          {{ produit.prix }} MAD
        </span>
        <span v-else class="text-lg font-bold text-text-primary">
          {{ produit.prix }} MAD
        </span>
      </div>

      <!-- Add to cart button with animation -->
      <BaseButton
        @click="$emit('add-to-cart', produit)"
        variant="primary"
        size="sm"
        fullWidth
        class="mt-3 bg-gradient-to-r from-accent-primary via-accent-primary to-accent-secondary border-0 hover:shadow-glow font-semibold"
        :loading="isAdding[produit.id]"
      >
        <svg class="w-4 h-4 mr-2 transition-transform duration-fast group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
        Ajouter au panier
      </BaseButton>
    </div>
  </div>
</template>

<script setup>
import { useWishlistStore } from '@/stores/wishlist'
import { useWishlist } from '@/composables/useWishlist'
import BaseButton from '@/components/ui/BaseButton.vue'

defineProps({
  produit: { type: Object, required: true },
  isAdding: { type: Object, default: () => ({}) },
})

defineEmits(['add-to-cart'])

const wishlistStore = useWishlistStore()
const { toggleWishlist } = useWishlist()
</script>
