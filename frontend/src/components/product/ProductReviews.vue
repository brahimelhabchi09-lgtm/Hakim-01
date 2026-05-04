<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-heading font-bold">Avis des clients</h2>
      <BaseButton v-if="authStore.isAuthenticated" @click="showForm = !showForm" variant="outline" size="sm">
        {{ showForm ? 'Annuler' : 'Ecrire un avis' }}
      </BaseButton>
    </div>

    <div
      v-if="showForm && authStore.isAuthenticated"
      class="bg-gray-50 rounded-lg p-4 space-y-4"
    >
      <div>
        <label class="input-label">Note</label>
        <StarRating v-model="form.note" interactive size="lg" />
      </div>
      <BaseInput v-model="form.titre" label="Titre" placeholder="Resume de votre avis" />
      <div>
        <label class="input-label">Avis</label>
        <textarea
          v-model="form.contenu"
          rows="4"
          class="input-field"
          placeholder="Decrivez votre experience..."
        />
      </div>
      <BaseButton
        @click="submitReview"
        :loading="submitting"
      >
        Soumettre l'avis
      </BaseButton>
    </div>

    <div v-if="!reviews || reviews.length === 0" class="text-center py-8 text-gray-500">
      <p>Aucun avis pour le moment.</p>
    </div>

    <div v-else class="space-y-4">
      <div
        v-for="avis in reviews"
        :key="avis.id"
        class="border-b pb-4"
      >
        <div class="flex items-center gap-2 mb-1">
          <StarRating :modelValue="avis.note" />
          <span class="text-sm text-gray-500">{{ avis.user.nom }}</span>
          <span class="text-sm text-gray-400">{{ formatDate(avis.created_at) }}</span>
        </div>
        <h4 v-if="avis.titre" class="font-medium">{{ avis.titre }}</h4>
        <p class="text-gray-600 mt-1 text-sm">{{ avis.contenu }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useToast } from '@/composables/useToast'
import StarRating from '@/components/ui/StarRating.vue'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseButton from '@/components/ui/BaseButton.vue'

const props = defineProps({
  produitId: { type: Number, required: true },
  reviews: { type: Array, default: () => [] },
})

const emit = defineEmits(['review-added'])

const authStore = useAuthStore()
const { success, error } = useToast()

const showForm = ref(false)
const submitting = ref(false)
const form = ref({
  note: 5,
  titre: '',
  contenu: '',
})

async function submitReview() {
  if (form.value.note < 1) {
    error('Veuillez donner une note.')
    return
  }

  submitting.value = true
  try {
    const api = (await import('@/services/api')).default
    await api.post(`/produits/${props.produitId}/avis`, form.value)
    success('Avis soumis. Il sera visible apres approbation.')
    showForm.value = false
    form.value = { note: 5, titre: '', contenu: '' }
    emit('review-added')
  } catch (e) {
    error(e.response?.data?.message || 'Erreur lors de la soumission')
  } finally {
    submitting.value = false
  }
}

function formatDate(date) {
  return new Date(date).toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'long',
    year: 'numeric',
  })
}
</script>
