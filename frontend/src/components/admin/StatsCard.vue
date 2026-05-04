<template>
  <div class="card p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm text-gray-500">{{ label }}</p>
        <p class="text-2xl font-heading font-bold text-secondary mt-1">{{ value }}</p>
        <p v-if="change" class="text-sm mt-1" :class="change >= 0 ? 'text-accent' : 'text-red-500'">
          {{ change >= 0 ? '+' : '' }}{{ change }}% vs periode precedente
        </p>
      </div>
      <div
        class="w-12 h-12 rounded-lg flex items-center justify-center"
        :class="`bg-${color}-50`"
      >
        <component :is="icon" :class="`h-6 w-6 text-${color}-500`" />
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  label: { type: String, required: true },
  value: { type: [String, Number], required: true },
  change: { type: Number, default: null },
  icon: { type: Object, default: null },
  color: { type: String, default: 'primary' },
})
</script>
