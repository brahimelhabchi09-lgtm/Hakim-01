<template>
  <div class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-heading font-bold text-secondary">Connexion</h1>
        <p class="text-gray-500 mt-1">Pas encore de compte? <router-link to="/inscription" class="text-primary hover:underline">Inscrivez-vous</router-link></p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <BaseInput v-model="form.email" label="Email" type="email" required :error="errors.email" />
        <BaseInput v-model="form.password" label="Mot de passe" type="password" required :error="errors.password" />

        <div v-if="globalError" class="bg-red-50 text-red-600 p-3 rounded-lg text-sm">
          {{ globalError }}
        </div>

        <BaseButton type="submit" :loading="loading" fullWidth>
          Se connecter
        </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuth } from '@/composables/useAuth'
import { useToast } from '@/composables/useToast'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseButton from '@/components/ui/BaseButton.vue'

const router = useRouter()
const route = useRoute()
const { login, loading, user } = useAuth()
const { error: toastError } = useToast()

const form = ref({ email: '', password: '' })
const errors = ref({})
const globalError = ref('')

onMounted(async () => {
  if (route.query.registered) {
    toastError('Inscription reussie! Connectez-vous maintenant.')
  }
})

async function handleLogin() {
  errors.value = {}
  globalError.value = ''

  const result = await login(form.value)

  if (result.success) {
    const redirect = route.query.redirect || '/compte'
    router.push(redirect)
  } else {
    if (result.errors.message) {
      globalError.value = result.errors.message
    } else {
      errors.value = result.errors
    }
  }
}
</script>
