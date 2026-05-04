<template>
  <div class="flex items-center gap-0.5">
    <template v-for="star in 5" :key="star">
      <button
        v-if="interactive"
        @click="$emit('update:modelValue', star)"
        class="focus:outline-none"
      >
        <StarIcon
          :class="[
            'h-5 w-5',
            star <= modelValue ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300',
          ]"
        />
      </button>
      <StarIcon
        v-else
        :class="[
          'h-4 w-4',
          star <= modelValue ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300',
          size === 'lg' && 'h-6 w-6',
        ]"
      />
    </template>
    <span v-if="showValue" class="ml-1 text-sm text-gray-600">
      {{ modelValue?.toFixed(1) }}
    </span>
    <span v-if="count !== undefined" class="text-sm text-gray-500">
      ({{ count }})
    </span>
  </div>
</template>

<script setup>
import { StarIcon } from '@heroicons/vue/24/solid'
import { StarIcon as StarOutline } from '@heroicons/vue/24/outline'

defineProps({
  modelValue: { type: Number, default: 0 },
  interactive: { type: Boolean, default: false },
  size: { type: String, default: 'md' },
  showValue: { type: Boolean, default: false },
  count: { type: Number, default: undefined },
})

defineEmits(['update:modelValue'])
</script>
