<template>
  <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
    <!-- Thumbnails -->
    <div class="hidden sm:flex flex-col gap-2">
      <button
        v-for="(img, index) in allImages"
        :key="index"
        @click="selectedImage = index"
        class="w-20 h-20 rounded-lg overflow-hidden border-2 transition-all duration-fast"
        :class="selectedImage === index ? 'border-accent shadow-glow' : 'border-border hover:border-border-light'"
      >
        <img :src="img" class="w-full h-full object-cover" loading="lazy" />
      </button>
    </div>

    <!-- Main Image -->
    <div class="sm:col-span-4 aspect-square rounded-xl overflow-hidden bg-bg-secondary relative group">
      <img
        :src="allImages[selectedImage]"
        :alt="produit.nom"
        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-slow"
        loading="lazy"
      />

      <div
        v-if="produit.en_promotion"
        class="absolute top-4 left-4 px-3 py-1 bg-red-500 text-white text-sm font-bold rounded shadow-lg"
      >
        -{{ produit.reduction_percentage }}%
      </div>

      <!-- Zoom hint -->
      <div class="absolute bottom-4 right-4 bg-bg-card/80 backdrop-blur-sm px-3 py-1 rounded-full text-text-secondary text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-fast">
        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
        Clic pour zoomer
      </div>
    </div>

    <!-- Mobile Thumbnails -->
    <div class="sm:hidden flex gap-2 overflow-x-auto scrollbar-hide">
      <button
        v-for="(img, index) in allImages"
        :key="index"
        @click="selectedImage = index"
        class="w-16 h-16 rounded-lg overflow-hidden border-2 flex-shrink-0 transition-all duration-fast"
        :class="selectedImage === index ? 'border-accent' : 'border-border'"
      >
        <img :src="img" class="w-full h-full object-cover" loading="lazy" />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  produit: { type: Object, required: true },
})

const selectedImage = ref(0)

const allImages = computed(() => {
  const images = []
  if (props.produit.image) {
    images.push(props.produit.image)
  }
  if (props.produit.images && Array.isArray(props.produit.images)) {
    images.push(...props.produit.images)
  }
  if (images.length === 0) {
    images.push('/placeholder-product.jpg')
  }
  return images
})
</script>
