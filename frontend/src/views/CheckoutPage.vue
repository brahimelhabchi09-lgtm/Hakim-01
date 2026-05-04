<template>
  <div class="container-custom py-8">
    <h1 class="text-2xl font-heading font-bold mb-6">Passer la commande</h1>

    <CheckoutSteps :current-step="currentStep" />

    <div v-if="currentStep === 1" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <h2 class="text-lg font-semibold mb-4">Recapitulatif du panier</h2>
        <div v-for="item in cartStore.items" :key="item.row_id" class="flex items-center gap-4 py-3 border-b">
          <img :src="item.produit.image || '/placeholder-product.jpg'" class="w-16 h-16 object-cover rounded" />
          <div class="flex-1">
            <p class="font-medium text-sm">{{ item.produit.nom }}</p>
            <p class="text-gray-500 text-sm">x{{ item.quantite }}</p>
          </div>
          <p class="font-bold">{{ item.sous_total.toFixed(2) }} MAD</p>
        </div>
      </div>

      <CartSummary :subtotal="cartStore.subtotal" :shipping="cartStore.shipping">
        <button @click="currentStep = 2" class="btn-primary w-full mt-4">
          Continuer
        </button>
      </CartSummary>
    </div>

    <div v-if="currentStep === 2" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <AddressForm v-model="shippingAddress" :errors="errors" />
        <div class="mt-4">
          <label class="input-label">Notes (optionnel)</label>
          <textarea v-model="notes" class="input-field" rows="3" placeholder="Instructions speciales pour la livraison..." />
        </div>
      </div>

      <CartSummary :subtotal="cartStore.subtotal" :shipping="cartStore.shipping">
        <div class="flex gap-2 mt-4">
          <button @click="currentStep = 1" class="btn-outline flex-1">
            Retour
          </button>
          <button @click="currentStep = 3" class="btn-primary flex-1">
            Continuer
          </button>
        </div>
      </CartSummary>
    </div>

    <div v-if="currentStep === 3" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2">
        <h2 class="text-lg font-semibold mb-4">Mode de paiement</h2>
        <div class="space-y-3">
          <label class="flex items-center gap-3 p-4 border rounded-lg cursor-pointer hover:bg-bg-hover transition-all duration-300" :class="{ 'border-accent-primary bg-bg-elevated': paymentMethod === 'cash' }">
            <input v-model="paymentMethod" type="radio" value="cash" class="text-primary" />
            <div>
              <p class="font-medium">Paiement a la livraison</p>
              <p class="text-sm text-gray-500">Payez en especes quand vous recevez votre commande</p>
            </div>
          </label>
        </div>
      </div>

      <CartSummary :subtotal="cartStore.subtotal" :shipping="cartStore.shipping">
        <div class="flex gap-2 mt-4">
          <button @click="currentStep = 2" class="btn-outline flex-1" :disabled="submitting">
            Retour
          </button>
          <button @click="placeOrder" :disabled="submitting" class="btn-primary flex-1">
            {{ getButtonText() }}
          </button>
        </div>
      </CartSummary>
    </div>

    <div v-if="currentStep === 4 && order" class="max-w-2xl mx-auto">
      <OrderConfirmation :order="order" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useCartStore } from '@/stores/cart'
import { useToast } from '@/composables/useToast'
import CheckoutSteps from '@/components/checkout/CheckoutSteps.vue'
import AddressForm from '@/components/checkout/AddressForm.vue'
import CartSummary from '@/components/cart/CartSummary.vue'
import OrderConfirmation from '@/components/checkout/OrderConfirmation.vue'
import api from '@/services/api'

const router = useRouter()
const cartStore = useCartStore()
const { success, error } = useToast()

const currentStep = ref(1)
const submitting = ref(false)
const order = ref(null)
const notes = ref('')
const paymentMethod = ref('cash')
const errors = ref({})
const shippingAddress = ref({
  nom: '',
  prenom: '',
  telephone: '',
  adresse: '',
  ville: '',
  code_postal: '',
})

onMounted(async () => {
  await cartStore.fetchCart()
  if (cartStore.isEmpty) {
    router.push('/panier')
  }
})

function getButtonText() {
  if (submitting.value) return 'Traitement en cours...'
  return 'Confirmer la commande'
}

async function placeOrder() {
  if (!paymentMethod.value) {
    error('Veuillez selectionner un mode de paiement')
    return
  }

  submitting.value = true

  try {
    const response = await api.post('/commandes', {
      adresse_livraison: shippingAddress.value,
      adresse_facturation: shippingAddress.value,
      notes: notes.value,
      mode_paiement: paymentMethod.value,
    })

    order.value = response.data.commande
    currentStep.value = 4
    success('Commande passee avec succes!')
    } catch (e) {
    const data = e.response?.data
    const errorMessage = data?.error ? `${data.message}: ${data.error}` : (data?.message || 'Erreur lors de la commande')
    error(errorMessage)
    console.error('Payment error:', e.response?.data)
  } finally {
    submitting.value = false
  }
}
</script>
