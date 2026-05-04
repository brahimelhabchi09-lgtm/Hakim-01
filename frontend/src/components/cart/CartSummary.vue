<template>
  <div class="bg-gray-50 rounded-xl p-6 space-y-4">
    <h3 class="text-lg font-heading font-bold">Resume de la commande</h3>

    <div class="space-y-2 text-sm">
      <div class="flex justify-between">
        <span class="text-gray-600">Sous-total</span>
        <span>{{ subtotal.toFixed(2) }} MAD</span>
      </div>
      <div class="flex justify-between">
        <span class="text-gray-600">Livraison</span>
        <span>{{ shipping.toFixed(2) }} MAD</span>
      </div>
      <div v-if="promo > 0" class="flex justify-between text-accent">
        <span>Promo</span>
        <span>-{{ promo.toFixed(2) }} MAD</span>
      </div>
      <div class="border-t pt-2 mt-2">
        <div class="flex justify-between font-bold text-lg">
          <span>Total</span>
          <span class="text-primary">{{ (subtotal + shipping - promo).toFixed(2) }} MAD</span>
        </div>
      </div>
    </div>

    <div class="flex gap-2">
      <input
        v-model="promoCode"
        type="text"
        placeholder="Code promo"
        class="input-field text-sm"
      />
      <button
        @click="$emit('apply-promo', promoCode)"
        class="btn-secondary text-sm whitespace-nowrap"
      >
        Appliquer
      </button>
    </div>

    <slot />
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  subtotal: { type: Number, default: 0 },
  shipping: { type: Number, default: 0 },
  promo: { type: Number, default: 0 },
})

defineEmits(['apply-promo'])

const promoCode = ref('')
</script>
