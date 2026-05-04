<template>
  <div class="container-custom py-8">
    <h1 class="text-2xl font-heading font-bold mb-8">Mon Compte</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <aside class="md:col-span-1">
        <div class="card p-6">
          <div class="text-center mb-6">
            <div class="w-16 h-16 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-3">
              <UserIcon class="h-8 w-8 text-primary" />
            </div>
            <h2 class="font-semibold">{{ authStore.userName }}</h2>
            <p class="text-sm text-gray-500">{{ user?.email }}</p>
          </div>
          <nav class="space-y-1">
            <button @click="activeTab = 'orders'" class="w-full text-left px-3 py-2 rounded-md text-sm" :class="activeTab === 'orders' ? 'bg-primary-50 text-primary font-medium' : 'hover:bg-gray-50'">
              Mes commandes
            </button>
            <button @click="activeTab = 'notifications'" class="w-full text-left px-3 py-2 rounded-md text-sm flex items-center justify-between" :class="activeTab === 'notifications' ? 'bg-primary-50 text-primary font-medium' : 'hover:bg-gray-50'">
              <span>Notifications</span>
              <span v-if="unreadCount > 0" class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 rounded-full text-xs bg-primary text-white">
                {{ unreadCount }}
              </span>
            </button>
            <button @click="activeTab = 'profile'" class="w-full text-left px-3 py-2 rounded-md text-sm" :class="activeTab === 'profile' ? 'bg-primary-50 text-primary font-medium' : 'hover:bg-gray-50'">
              Mon profil
            </button>
          </nav>
        </div>
      </aside>

      <main class="md:col-span-2">
        <div v-if="activeTab === 'orders'">
          <h2 class="text-lg font-semibold mb-4">Mes commandes</h2>

          <div v-if="orders.length === 0" class="text-center py-8 text-gray-500">
            <p>Vous n'avez pas encore passe de commande.</p>
            <router-link to="/catalogue" class="text-primary hover:underline mt-2 inline-block">
              Decouvrir nos produits
            </router-link>
          </div>

          <div v-else class="space-y-4">
            <div v-for="order in orders" :key="order.id" class="card p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="font-bold">{{ order.num_commande }}</span>
                <span
                  class="badge"
                  :class="{
                    'badge-warning': order.statut === 'en_attente',
                    'badge-info': order.statut === 'en_cours',
                    'badge-success': order.statut === 'livree',
                  }"
                >
                  {{ order.statut_label }}
                </span>
              </div>
              <div class="text-sm text-gray-500 flex justify-between">
                <span>{{ formatDate(order.created_at) }}</span>
                <span class="font-bold text-primary">{{ order.total }} MAD</span>
              </div>
              <router-link
                :to="`/compte/commandes/${order.id}`"
                class="text-primary text-sm hover:underline mt-2 inline-block"
              >
                Voir les details →
              </router-link>
            </div>
          </div>
        </div>

        <div v-if="activeTab === 'profile'" class="card p-6">
          <h2 class="text-lg font-semibold mb-4">Mon profil</h2>
          <div class="space-y-4">
            <BaseInput :model-value="user?.prenom" label="Prenom" disabled />
            <BaseInput :model-value="user?.nom" label="Nom" disabled />
            <BaseInput :model-value="user?.email" label="Email" disabled />
            <BaseInput :model-value="user?.telephone || ''" label="Telephone" disabled />
          </div>
        </div>

        <div v-if="activeTab === 'notifications'" class="card p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Mes notifications</h2>
            <button
              v-if="unreadCount > 0"
              @click="markAllNotificationsAsRead"
              class="text-primary text-sm hover:underline"
            >
              Tout marquer comme lu
            </button>
          </div>

          <div v-if="notifications.length === 0" class="text-sm text-gray-500">
            Aucune notification pour le moment.
          </div>

          <div v-else class="space-y-3">
            <div
              v-for="notification in notifications"
              :key="notification.id"
              class="p-4 rounded-lg border"
              :class="notification.read_at ? 'border-gray-200 bg-white' : 'border-primary bg-primary-50/20'"
            >
              <div class="flex items-start justify-between gap-3">
                <div>
                  <p class="font-medium text-sm">{{ notification.data?.message || 'Mise a jour de commande' }}</p>
                  <p class="text-xs text-gray-500 mt-1">{{ formatDate(notification.created_at) }}</p>
                </div>
                <button
                  v-if="!notification.read_at"
                  @click="markNotificationAsRead(notification.id)"
                  class="text-xs text-primary hover:underline"
                >
                  Marquer lu
                </button>
              </div>
              <router-link
                v-if="notification.data?.url"
                :to="notification.data.url"
                class="text-primary text-xs hover:underline inline-block mt-2"
              >
                Voir la commande
              </router-link>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import BaseInput from '@/components/ui/BaseInput.vue'
import { UserIcon } from '@heroicons/vue/24/outline'
import api from '@/services/api'

const authStore = useAuthStore()
const activeTab = ref('orders')
const user = ref(authStore.user)
const orders = ref([])
const notifications = ref([])
const unreadCount = ref(0)

onMounted(async () => {
  await authStore.fetchUser()
  user.value = authStore.user
  try {
    const response = await api.get('/commandes')
    orders.value = response.data.data || response.data
  } catch {
    orders.value = []
  }

  await fetchNotifications()
})

function formatDate(date) {
  return new Date(date).toLocaleString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' })
}

async function fetchNotifications() {
  try {
    const response = await api.get('/notifications')
    notifications.value = response.data.notifications || []
    unreadCount.value = response.data.unread_count || 0
  } catch {
    notifications.value = []
    unreadCount.value = 0
  }
}

async function markNotificationAsRead(notificationId) {
  try {
    await api.put(`/notifications/${notificationId}/read`)
    await fetchNotifications()
  } catch {
  }
}

async function markAllNotificationsAsRead() {
  try {
    await api.put('/notifications/read-all')
    await fetchNotifications()
  } catch {
  }
}
</script>
