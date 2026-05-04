<template>
  <div class="flex items-center gap-4 py-4 border-b">
    <img
      :src="item.produit.image || '/placeholder-product.jpg'"
      :alt="item.produit.nom"
      class="w-24 h-24 object-cover rounded-lg"
    />
    <div class="flex-1 min-w-0">
      <router-link :to="`/produit/${item.produit.slug}`" class="font-medium hover:text-primary">
        {{ item.produit.nom }}
      </router-link>
      <div v-if="item.produit.marque" class="text-sm text-gray-500">
        {{ item.produit.marque.nom }}
      </div>
      <div class="flex items-center justify-between mt-2">
        <div class="flex items-center border rounded-lg">
          <button
            @click="$emit('update-qty', item.row_id, item.quantite - 1)"
            class="px-3 py-1 hover:bg-gray-100"
            :disabled="item.quantite <= 1"
          >
            <MinusIcon class="h-3 w-3" />
          </button>
          <span class="px-3 text-sm font-medium">{{ item.quantite }}</span>
          <button
            @click="$emit('update-qty', item.row_id, item.quantite + 1)"
            class="px-3 py-1 hover:bg-gray-100"
          >
            <PlusIcon class="h-3 w-3" />
          </button>
        </div>
        <span class="font-bold text-primary">{{ item.sous_total.toFixed(2) }} MAD</span>
      </div>
    </div>
    <button
      @click="$emit('remove', item.row_id)"
      class="p-2 text-gray-400 hover:text-red-500"
    >
      <TrashIcon class="h-5 w-5" />
    </button>
  </div>
</template>

<script setup>
import { MinusIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline'

defineProps({
  item: { type: Object, required: true },
})

defineEmits(['update-qty', 'remove'])
</script>
