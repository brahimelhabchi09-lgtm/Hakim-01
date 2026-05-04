<template>
  <div class="space-y-6">
    <!-- Origin Badge -->
    <div v-if="produit.pays_origine" class="inline-flex items-center gap-2 px-3 py-1 bg-bg-elevated rounded-full border border-border">
      <span class="text-sm">{{ getOriginFlag(produit.pays_origine) }}</span>
      <span class="text-sm text-text-secondary">{{ getOriginName(produit.pays_origine) }}</span>
    </div>

    <!-- Brand -->
    <div v-if="produit.marque" class="text-sm text-text-secondary">
      Marque: <span class="text-text-primary font-semibold">{{ produit.marque.nom }}</span>
    </div>

    <!-- Title -->
    <h1 class="text-2xl lg:text-3xl font-display font-bold text-text-primary">
      {{ produit.nom }}
    </h1>

    <!-- Rating -->
    <div class="flex items-center gap-3">
      <div class="flex text-yellow-400">
        <svg v-for="i in 5" :key="i" class="w-5 h-5" :class="i <= Math.round(produit.avis_moyenne || 0) ? 'fill-current' : 'fill-gray-600'" viewBox="0 0 20 20">
          <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
        </svg>
      </div>
      <span class="text-sm text-text-secondary">
        {{ produit.avis_moyenne || 0 }} ({{ produit.avis_total || 0 }} avis)
      </span>
    </div>

    <!-- Price -->
    <div class="flex items-baseline gap-3">
      <span v-if="produit.prix_promotionnel" class="text-3xl font-bold text-accent">
        {{ produit.prix_promotionnel }} MAD
      </span>
      <span
        v-if="produit.prix_promotionnel"
        class="text-xl text-text-muted line-through"
      >
        {{ produit.prix }} MAD
      </span>
      <span v-else class="text-3xl font-bold text-text-primary">
        {{ produit.prix }} MAD
      </span>
      <span
        v-if="produit.prix_promotionnel"
        class="px-2 py-1 text-xs font-bold bg-red-500 text-white rounded"
      >
        -{{ Math.round((1 - produit.prix_promotionnel / produit.prix) * 100) }}%
      </span>
    </div>

    <!-- Description -->
    <div v-if="produit.description" class="text-text-secondary leading-relaxed">
      <p>{{ produit.description }}</p>
    </div>

    <!-- Quantity and Add to Cart -->
    <div class="flex items-center gap-4">
      <div class="flex items-center bg-bg-secondary border border-border rounded-lg">
        <button
          @click="quantity = Math.max(1, quantity - 1)"
          class="px-4 py-2 hover:bg-bg-hover transition-colors"
          :disabled="quantity <= 1"
        >
          <svg class="h-4 w-4 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
        </button>
        <input
          v-model.number="quantity"
          type="number"
          min="1"
          :max="produit.stock"
          class="w-16 text-center py-2 bg-transparent text-text-primary focus:outline-none border-x border-border"
        />
        <button
          @click="quantity = Math.min(produit.stock, quantity + 1)"
          class="px-4 py-2 hover:bg-bg-hover transition-colors"
          :disabled="quantity >= produit.stock"
        >
          <svg class="h-4 w-4 text-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </button>
      </div>

      <span class="text-sm text-text-muted">
        {{ produit.stock > 0 ? `${produit.stock} en stock` : 'Rupture de stock' }}
      </span>
    </div>

    <div class="flex gap-3">
      <BaseButton
        @click="$emit('add-to-cart', produit.id, quantity)"
        variant="primary"
        fullWidth
        :disabled="produit.stock === 0"
        :loading="isAdding"
        class="gradient-accent border-0"
      >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
        Ajouter au panier
      </BaseButton>

      <button
        @click="toggleWishlist(produit.id)"
        class="p-3 border border-border rounded-lg hover:bg-bg-hover transition-colors"
        :class="isInWishlist ? 'text-red-500 border-red-500' : 'text-text-secondary'"
      >
        <svg class="w-6 h-6" :class="isInWishlist ? 'fill-current' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      </button>
    </div>

    <!-- Features -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-6 border-t border-border">
      <div class="flex items-center gap-2 text-text-secondary">
        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
        <span class="text-sm">Livraison 24-48h</span>
      </div>
      <div class="flex items-center gap-2 text-text-secondary">
        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        <span class="text-sm">Origine garantie</span>
      </div>
      <div class="flex items-center gap-2 text-text-secondary">
        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        <span class="text-sm">Paiement sécurisé</span>
      </div>
    </div>

    <!-- Tags -->
    <div v-if="produit.tags?.length" class="flex flex-wrap gap-2 pt-4 border-t border-border">
      <span
        v-for="tag in produit.tags"
        :key="tag"
        class="px-3 py-1 text-xs rounded-full border border-border text-text-secondary hover:border-accent hover:text-accent transition-colors"
      >
        {{ tag }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useWishlistStore } from '@/stores/wishlist'
import { useWishlist } from '@/composables/useWishlist'
import BaseButton from '@/components/ui/BaseButton.vue'

const props = defineProps({
  produit: { type: Object, required: true },
  isAdding: { type: Boolean, default: false },
})

defineEmits(['add-to-cart'])

const quantity = ref(1)

const wishlistStore = useWishlistStore()
const { toggleWishlist } = useWishlist()

const isInWishlist = computed(() => wishlistStore.isInWishlist(props.produit.id))

function getOriginFlag(code) {
  const flags = {
    'BR': '🇧🇷', 'ES': '🇪🇸', 'DE': '🇩🇪', 'BE': '🇧🇪', 'CN': '🇨🇳',
    'FR': '🇫🇷', 'AT': '🇦🇹', 'US': '🇺🇸', 'CH': '🇨🇭', 'JP': '🇯🇵',
    'KR': '🇰🇷', 'IT': '🇮🇹', 'TW': '🇹🇼', 'WORLD': '🌍',
    '?': '❓', '???': '❓'
  }
  return flags[code] || '🏳️'
}

function getOriginName(code) {
  const names = {
    'BR': 'Brésil', 'ES': 'Espagne', 'DE': 'Allemagne', 'BE': 'Belgique',
    'CN': 'Chine', 'FR': 'France', 'AT': 'Autriche', 'US': 'États-Unis',
    'CH': 'Suisse', 'JP': 'Japon', 'KR': 'Corée du Sud', 'IT': 'Italie',
    'TW': 'Taïwan', 'WORLD': 'Monde', '?': 'Inconnu', '???': 'Mystère'
  }
  return names[code] || code
}
</script>
