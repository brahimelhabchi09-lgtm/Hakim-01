<template>
  <div class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="w-full max-w-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-heading font-bold text-secondary">Inscription</h1>
        <p class="text-gray-500 mt-1">Deja un compte? <router-link to="/connexion" class="text-primary hover:underline">Connectez-vous</router-link></p>
      </div>

      <form @submit.prevent="handleRegister" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <BaseInput v-model="form.prenom" label="Prenom" required :error="errors.prenom" />
          <BaseInput v-model="form.nom" label="Nom" required :error="errors.nom" />
        </div>

        <BaseInput v-model="form.email" label="Email" type="email" required :error="errors.email" />
        <BaseInput v-model="form.telephone" label="Telephone" type="tel" :error="errors.telephone" />

        <BaseInput v-model="form.password" label="Mot de passe" type="password" required :error="errors.password" />
        <BaseInput v-model="form.password_confirmation" label="Confirmer le mot de passe" type="password" required />

        <BaseButton type="submit" :loading="loading" fullWidth>
          S'inscrire
        </BaseButton>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '@/composables/useAuth'
import { useToast } from '@/composables/useToast'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseButton from '@/components/ui/BaseButton.vue'

const router = useRouter()
const { register, loading } = useAuth()
const { success, error } = useToast()

const form = ref({
  prenom: '',
  nom: '',
  email: '',
  telephone: '',
  password: '',
  password_confirmation: '',
})
const errors = ref({})

async function handleRegister() {
  errors.value = {}

  if (form.value.password !== form.value.password_confirmation) {
    errors.value.password_confirmation = 'Les mots de passe ne correspondent pas'
    return
  }

  const result = await register(form.value)

  if (result.success) {
    success('Inscription reussie!')
    router.push({ name: 'login', query: { registered: '1' } })
  } else {
    errors.value = result.errors
  }
}
</script>
