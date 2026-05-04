<template>
  <div class="space-y-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <BaseInput
        v-model="form.prenom"
        label="Prenom"
        required
        :error="errors.prenom"
      />
      <BaseInput
        v-model="form.nom"
        label="Nom"
        required
        :error="errors.nom"
      />
    </div>

    <BaseInput
      v-model="form.telephone"
      label="Telephone"
      required
      type="tel"
      :error="errors.telephone"
    />

    <BaseInput
      v-model="form.adresse"
      label="Adresse"
      required
      :error="errors.adresse"
    />

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <BaseInput
        v-model="form.ville"
        label="Ville"
        required
        :error="errors.ville"
      />
      <BaseInput
        v-model="form.code_postal"
        label="Code postal"
      />
      <BaseSelect
        v-model="form.quartier"
        label="Quartier"
        :options="[
          { value: '', label: 'Selectionner' },
          { value: 'centre', label: 'Centre ville' },
          { value: 'peripherie', label: 'Peripherie' },
        ]"
      />
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseSelect from '@/components/ui/BaseSelect.vue'

const props = defineProps({
  modelValue: { type: Object, default: () => ({}) },
  errors: { type: Object, default: () => ({}) },
})

const emit = defineEmits(['update:modelValue'])

const form = reactive({
  nom: props.modelValue.nom || '',
  prenom: props.modelValue.prenom || '',
  telephone: props.modelValue.telephone || '',
  adresse: props.modelValue.adresse || '',
  ville: props.modelValue.ville || '',
  code_postal: props.modelValue.code_postal || '',
  quartier: props.modelValue.quartier || '',
})

import { watch } from 'vue'
watch(form, (val) => {
  emit('update:modelValue', { ...val })
}, { deep: true })
</script>
