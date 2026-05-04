<template>
  <div class="flex items-center justify-center mb-8">
    <div class="flex items-center gap-2 sm:gap-4">
      <template v-for="(step, index) in steps" :key="step.key">
        <div class="flex flex-col items-center">
          <div
            class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
            :class="[
              index + 1 < currentStep || index + 1 === currentStep
                ? 'bg-primary text-white'
                : 'bg-gray-200 text-gray-500',
            ]"
          >
            <CheckIcon v-if="index + 1 < currentStep" class="h-4 w-4" />
            {{ index + 1 }}
          </div>
          <span
            class="text-xs mt-1 hidden sm:block"
            :class="index + 1 <= currentStep ? 'text-primary font-medium' : 'text-gray-400'"
          >
            {{ step.label }}
          </span>
        </div>
        <div
          v-if="index < steps.length - 1"
          class="w-8 sm:w-16 h-0.5"
          :class="index + 1 < currentStep ? 'bg-primary' : 'bg-gray-200'"
        />
      </template>
    </div>
  </div>
</template>

<script setup>
import { CheckIcon } from '@heroicons/vue/24/solid'

defineProps({
  currentStep: { type: Number, default: 1 },
  steps: {
    type: Array,
    default: () => [
      { key: 'summary', label: 'Recapitulatif' },
      { key: 'shipping', label: 'Livraison' },
      { key: 'payment', label: 'Paiement' },
      { key: 'confirmation', label: 'Confirmation' },
    ],
  },
})
</script>
