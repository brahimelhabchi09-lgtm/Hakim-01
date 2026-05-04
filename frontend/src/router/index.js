import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const routes = [
  {
    path: '/',
    name: 'home',
    component: () => import('@/views/HomePage.vue'),
  },
  {
    path: '/catalogue',
    name: 'catalog',
    component: () => import('@/views/CatalogPage.vue'),
  },
  {
    path: '/categorie/:slug',
    name: 'category',
    component: () => import('@/views/CategoryPage.vue'),
  },
  {
    path: '/produit/:slug',
    name: 'product',
    component: () => import('@/views/ProductPage.vue'),
  },
  {
    path: '/panier',
    name: 'cart',
    component: () => import('@/views/CartPage.vue'),
  },
  {
    path: '/checkout',
    name: 'checkout',
    component: () => import('@/views/CheckoutPage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/wishlist',
    name: 'wishlist',
    component: () => import('@/views/WishlistPage.vue'),
  },
  {
    path: '/connexion',
    name: 'login',
    component: () => import('@/views/LoginPage.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/inscription',
    name: 'register',
    component: () => import('@/views/RegisterPage.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/compte',
    name: 'account',
    component: () => import('@/views/AccountPage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/compte/commandes/:id',
    name: 'order-detail',
    component: () => import('@/views/OrderDetailPage.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import('@/views/admin/DashboardPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/produits',
    name: 'admin-products',
    component: () => import('@/views/admin/ProductsPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/produits/creer',
    name: 'admin-product-create',
    component: () => import('@/views/admin/ProductCreatePage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/produits/:id/edit',
    name: 'admin-product-edit',
    component: () => import('@/views/admin/ProductEditPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/commandes',
    name: 'admin-orders',
    component: () => import('@/views/admin/OrdersPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/commandes/:id',
    name: 'admin-order-detail',
    component: () => import('@/views/admin/OrderDetailPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: '/admin/avis',
    name: 'admin-reviews',
    component: () => import('@/views/admin/ReviewsPage.vue'),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    return { top: 0 }
  },
})

router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()

  if (to.meta.requiresAuth || to.meta.requiresAdmin) {
    // If not authenticated (no token), redirect to login
    if (!authStore.isAuthenticated) {
      return next({ name: 'login', query: { redirect: to.fullPath } })
    }

    // If we have a token but no user data, fetch user first
    if (!authStore.user) {
      try {
        await authStore.fetchUser()
      } catch (e) {
        // If fetch fails, redirect to login
        localStorage.removeItem('token')
        return next({ name: 'login', query: { redirect: to.fullPath } })
      }
    }

    // Check admin requirement
    if (to.meta.requiresAdmin && !authStore.isAdmin) {
      return next({ name: 'home' })
    }
  }

  if (to.meta.requiresGuest && authStore.isAuthenticated) {
    if (!authStore.user && authStore.token) {
      try {
        await authStore.fetchUser()
      } catch {
        return next()
      }
    }
    return next({ name: 'account' })
  }

  next()
})

export default router
