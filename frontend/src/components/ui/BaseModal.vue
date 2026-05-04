<template>
  <Teleport to="body">
    <Transition name="modal">
      <div v-if="modelValue" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50" @click="$emit('update:modelValue', false)" />
        <div class="relative bg-white rounded-xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
          <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-heading font-bold">{{ title }}</h3>
            <button
              @click="$emit('update:modelValue', false)"
              class="p-1 text-gray-400 hover:text-gray-600 rounded"
            >
              <XMarkIcon class="h-5 w-5" />
            </button>
          </div>
          <div class="p-4">
            <slot />
          </div>
          <div v-if="$slots.footer" class="p-4 border-t bg-gray-50">
            <slot name="footer" />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { XMarkIcon } from '@heroicons/vue/24/outline'

defineProps({
  modelValue: Boolean,
  title: { type: String, default: '' },
})

defineEmits(['update:modelValue'])
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
  transition: transform 0.2s ease;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
  transform: scale(0.95);
}
</style>
