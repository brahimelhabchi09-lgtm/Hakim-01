<template>
  <div class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm">
    <TransitionGroup name="toast">
      <div
        v-for="toast in toasts"
        :key="toast.id"
        class="bg-white rounded-lg shadow-lg border p-4 flex items-start gap-3"
        :class="{
          'border-accent': toast.type === 'success',
          'border-red-500': toast.type === 'error',
          'border-yellow-500': toast.type === 'warning',
          'border-blue-500': toast.type === 'info',
        }"
      >
        <div
          class="flex-shrink-0 mt-0.5"
          :class="{
            'text-accent': toast.type === 'success',
            'text-red-500': toast.type === 'error',
            'text-yellow-500': toast.type === 'warning',
            'text-blue-500': toast.type === 'info',
          }"
        >
          <CheckCircleIcon v-if="toast.type === 'success'" class="h-5 w-5" />
          <XCircleIcon v-else-if="toast.type === 'error'" class="h-5 w-5" />
          <ExclamationTriangleIcon v-else-if="toast.type === 'warning'" class="h-5 w-5" />
          <InformationCircleIcon v-else class="h-5 w-5" />
        </div>
        <p class="text-sm flex-1">{{ toast.message }}</p>
        <button @click="removeToast(toast.id)" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
          <XMarkIcon class="h-4 w-4" />
        </button>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>
import { useToast } from '@/composables/useToast'
import { CheckCircleIcon, XCircleIcon, ExclamationTriangleIcon, InformationCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline'

const { toasts, removeToast } = useToast()
</script>

<style scoped>
.toast-enter-active {
  transition: all 0.3s ease;
}

.toast-leave-active {
  transition: all 0.2s ease;
}

.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}

.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
