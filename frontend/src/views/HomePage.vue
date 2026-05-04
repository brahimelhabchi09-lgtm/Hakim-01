<template>
  <div class="bg-gradient-to-br from-bg-primary via-bg-secondary to-bg-primary">
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-bg-primary via-bg-card to-bg-primary py-16 lg:py-32 overflow-hidden animate-fade-slide-up">
      <div class="absolute inset-0 opacity-10 pointer-events-none">
        <div class="absolute top-10 left-10 text-8xl animate-float">🐺</div>
        <div class="absolute top-20 right-20 text-8xl animate-float" style="animation-delay: 0.5s;">🐺</div>
        <div class="absolute bottom-10 left-1/4 text-8xl animate-float" style="animation-delay: 1s;">🐺</div>
        <div class="absolute bottom-20 right-1/3 text-8xl animate-float" style="animation-delay: 1.5s;">🐺</div>
      </div>
      <div class="container-custom relative z-10">
        <div class="max-w-2xl">
          <h1 class="text-4xl lg:text-6xl font-display font-bold mb-6 animate-tilt">
            <span class="bg-gradient-to-r from-accent-primary via-accent-secondary to-accent-primary bg-clip-text text-transparent">WolfStore</span>
            <br />
            <span class="text-text-primary">Premium Products Worldwide</span>
          </h1>
          <p class="text-lg text-text-secondary mb-8 leading-relaxed">
            Discover our curated collection of premium products from around the globe. 
            Authentic flavors, exclusive items, and world-class quality delivered to your doorstep.
          </p>
          <div class="flex flex-wrap gap-4">
            <router-link to="/catalogue" class="btn-primary text-lg px-8 py-4 border-0 font-semibold">
              Explore Catalogue
            </router-link>
            <router-link to="/catalogue?category=mystery" class="btn-secondary text-lg px-8 py-4">
              🎁 Mystery Box
            </router-link>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-12 bg-bg-secondary/50 animate-fade-slide-up">
      <div class="container-custom">
        <h2 class="section-title text-center mb-8">Popular Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
          <div
            v-for="cat in featuredCategories"
            :key="cat.slug"
            class="card p-6 text-center cursor-pointer hover:border-accent-secondary hover:shadow-glow-cyan transition-all duration-normal group animate-scale-in"
            @click="goToCategory(cat.slug)"
          >
            <div class="w-16 h-16 mx-auto mb-3 bg-gradient-to-br from-accent-primary/20 to-accent-secondary/20 rounded-full flex items-center justify-center group-hover:from-accent-primary/40 group-hover:to-accent-secondary/40 transition-all duration-normal group-hover:scale-110">
              <span class="text-3xl group-hover:animate-pulse">{{ cat.icon }}</span>
            </div>
            <h3 class="font-semibold text-sm text-text-primary group-hover:text-accent-secondary transition-colors duration-fast">
              {{ cat.nom }}
            </h3>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products -->
    <section class="py-12 animate-fade-slide-up">
      <div class="container-custom">
        <div class="flex items-center justify-between mb-8">
          <h2 class="section-title">Featured Products</h2>
          <router-link to="/catalogue" class="text-accent-secondary hover:text-accent-primary transition-colors text-sm font-medium">
            View All →
          </router-link>
        </div>

        <div v-if="loading" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <ProductCardSkeleton v-for="i in 8" :key="i" />
        </div>

        <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <ProductCard
            v-for="produit in featured"
            :key="produit.id"
            :produit="produit"
            @add-to-cart="handleAddToCart"
          />
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-bg-secondary animate-fade-slide-up">
      <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-accent/20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="text-lg font-bold text-text-primary mb-2">Livraison Rapide</h3>
            <p class="text-text-secondary text-sm">Livraison 24-48h partout au Maroc</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-accent/20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-text-primary mb-2">Origine Garantie</h3>
            <p class="text-text-secondary text-sm">Tous nos produits sont authentiques</p>
          </div>
          <div class="text-center">
            <div class="w-16 h-16 mx-auto mb-4 bg-accent/20 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-text-primary mb-2">Paiement Sécurisé</h3>
            <p class="text-text-secondary text-sm">Transactions 100% sécurisées</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Mystery Products Banner -->
    <section class="py-16 bg-gradient-to-r from-bg-primary to-bg-secondary animate-fade-slide-up">
      <div class="container-custom text-center">
        <div class="max-w-2xl mx-auto">
          <span class="text-6xl mb-4 block">🎁</span>
          <h2 class="text-3xl lg:text-4xl font-display font-bold text-text-primary mb-4">
            Mystery Box & Produits Surprise
          </h2>
          <p class="text-text-secondary mb-8">
            Découvrez nos produits mystères et marques blanches à prix imbattables. 
            La surprise fait partie du plaisir !
          </p>
          <router-link to="/catalogue?category=mystery" class="btn-primary text-lg px-8 py-4 gradient-accent border-0">
            Explorer les Mystères
          </router-link>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useProductsStore } from '@/stores/products'
import { useToast } from '@/composables/useToast'
import { useCart } from '@/composables/useCart'
import ProductCard from '@/components/ui/ProductCard.vue'
import ProductCardSkeleton from '@/components/ui/ProductCardSkeleton.vue'

const router = useRouter()
const productsStore = useProductsStore()
const { success, error } = useToast()
const { addToCart } = useCart()

const featured = ref([])
const loading = ref(true)

const featuredCategories = [
  { slug: 'biscuits-snacks', nom: 'Biscuits & Snacks', icon: '🍪' },
  { slug: 'energy-drinks', nom: 'Energy Drinks', icon: '⚡' },
  { slug: 'boissons', nom: 'Boissons', icon: '🥤' },
  { slug: 'confiserie', nom: 'Confiserie', icon: '🍬' },
  { slug: 'cafe-the', nom: 'Café & Thé', icon: '☕' },
]

onMounted(async () => {
  featured.value = await productsStore.fetchFeatured()
  loading.value = false
})

function goToCategory(slug) {
  router.push(`/catalogue?category=${slug}`)
}

async function handleAddToCart(product) {
  const produitId = Number(typeof product === 'object' ? product?.id : product)
  if (!produitId) return
  const result = await addToCart(produitId)
  if (result.success) {
    success('Produit ajoute au panier')
  } else {
    error(result.message || 'Erreur lors de l\'ajout au panier')
  }
}
</script>
