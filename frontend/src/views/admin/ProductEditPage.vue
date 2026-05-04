<template>
  <div class="flex min-h-screen">
    <AdminSidebar />
    <main class="flex-1 p-8">
      <div class="flex items-center gap-4 mb-6">
        <router-link to="/admin/produits" class="text-gray-500 hover:text-primary">← Retour</router-link>
        <h1 class="text-2xl font-heading font-bold">Modifier le produit</h1>
      </div>

      <form v-if="produit" @submit.prevent="handleSubmit" class="max-w-2xl space-y-6">
        <div class="card p-6 space-y-4">
          <BaseInput v-model="form.nom" label="Nom" required />
          <div>
            <label class="input-label">Description</label>
            <textarea v-model="form.description" rows="4" class="input-field" />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <BaseInput v-model.number="form.prix" label="Prix (MAD)" type="number" required />
            <BaseInput v-model.number="form.prix_promotionnel" label="Prix promotionnel" type="number" />
          </div>
          <div class="grid grid-cols-2 gap-4">
            <BaseInput v-model.number="form.stock" label="Stock" type="number" required />
              <div class="flex items-center gap-4 pt-6">
                <label class="flex items-center gap-2">
                  <input v-model="form.en_vedette" type="checkbox" class="rounded text-primary" />
                  <span class="text-sm">En vedette</span>
                </label>
              </div>
          </div>
        </div>

        <div class="card p-6 space-y-4">
          <div>
            <label class="input-label">Image principale actuelle</label>
            <img v-if="produit.image_principale" :src="`/storage/${produit.image_principale}`" class="w-32 h-32 object-cover rounded mb-2" />
            <input type="file" accept="image/*" @change="handleMainImage" class="input-field" />
            <img v-if="mainImagePreview" :src="mainImagePreview" class="mt-2 w-32 h-32 object-cover rounded" />
          </div>
          <div>
            <label class="input-label">Images de galerie actuelles</label>
            <div class="flex gap-2 flex-wrap mb-2">
              <img v-for="(img, i) in produit.images_galerie || []" :key="i" :src="`/storage/${img}`" class="w-20 h-20 object-cover rounded" />
            </div>
            <input type="file" accept="image/*" multiple @change="handleGalleryImages" class="input-field" />
            <div class="flex gap-2 mt-2 flex-wrap">
              <img v-for="(img, i) in galleryPreviews" :key="i" :src="img" class="w-20 h-20 object-cover rounded" />
            </div>
          </div>
        </div>

        <div class="card p-6 space-y-4">
          <BaseSelect v-model="form.category_id" label="Categorie" :options="categoryOptions" />
          <BaseSelect v-model="form.marque_id" label="Marque" :options="marqueOptions" />
        </div>

        <div class="flex gap-2">
          <BaseButton type="submit" :loading="submitting">Sauvegarder</BaseButton>
          <router-link to="/admin/produits" class="btn-outline">Annuler</router-link>
        </div>
      </form>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useToast } from '@/composables/useToast'
import AdminSidebar from '@/components/admin/AdminSidebar.vue'
import BaseInput from '@/components/ui/BaseInput.vue'
import BaseSelect from '@/components/ui/BaseSelect.vue'
import BaseButton from '@/components/ui/BaseButton.vue'
import api from '@/services/api'

const route = useRoute()
const router = useRouter()
const { success, error } = useToast()

const submitting = ref(false)
const produit = ref(null)
const categories = ref([])
const marques = ref([])
const mainImage = ref(null)
const mainImagePreview = ref(null)
const galleryImages = ref([])
const galleryPreviews = ref([])

const form = ref({
  nom: '',
  description: '',
  prix: 0,
  prix_promotionnel: null,
  stock: 0,
  category_id: '',
  marque_id: '',
  en_vedette: false,
})

const categoryOptions = computed(() =>
  categories.value.map((c) => ({ value: c.id, label: c.nom }))
)

const marqueOptions = computed(() =>
  marques.value.map((m) => ({ value: m.id, label: m.nom }))
)

onMounted(async () => {
  try {
    const [prodRes, catsRes, mrqsRes] = await Promise.all([
      api.get(`/admin/produits/${route.params.id}`),
      api.get('/admin/categories'),
      api.get('/admin/marques'),
    ])
    produit.value = prodRes.data.produit
    categories.value = catsRes.data.categories
    marques.value = mrqsRes.data.marques

    form.value = {
      nom: produit.value.nom,
      description: produit.value.description || '',
      prix: parseFloat(produit.value.prix),
      prix_promotionnel: produit.value.prix_promotionnel ? parseFloat(produit.value.prix_promotionnel) : null,
      stock: produit.value.stock,
      category_id: produit.value.category?.id || '',
      marque_id: produit.value.marque?.id || '',
      en_vedette: produit.value.en_vedette,
    }
  } catch {
    error('Produit non trouve')
    router.push('/admin/produits')
  }
})

function handleMainImage(e) {
  const file = e.target.files[0]
  if (file) {
    mainImage.value = file
    mainImagePreview.value = URL.createObjectURL(file)
  }
}

function handleGalleryImages(e) {
  const files = Array.from(e.target.files)
  galleryImages.value = files
  galleryPreviews.value = files.map((f) => URL.createObjectURL(f))
}

async function handleSubmit() {
  submitting.value = true
  try {
    const formData = new FormData()
    formData.append('_method', 'PUT')
    formData.append('nom', form.value.nom)
    formData.append('description', form.value.description || '')
    formData.append('prix', form.value.prix)
    formData.append('prix_promotionnel', form.value.prix_promotionnel || '')
    formData.append('stock', form.value.stock)
    formData.append('en_vedette', form.value.en_vedette ? '1' : '0')
    if (form.value.category_id) formData.append('category_id', form.value.category_id)
    if (form.value.marque_id) formData.append('marque_id', form.value.marque_id)
    if (mainImage.value) formData.append('image', mainImage.value)
    galleryImages.value.forEach((img) => formData.append('images[]', img))

    await api.post(`/admin/produits/${route.params.id}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    })
    success('Produit modifie avec succes')
    router.push('/admin/produits')
  } catch (e) {
    error(e.response?.data?.message || 'Erreur lors de la modification')
  } finally {
    submitting.value = false
  }
}
</script>
