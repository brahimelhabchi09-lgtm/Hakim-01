import { describe, it, expect, beforeEach } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'
import { useCartStore } from '../../stores/cart'

describe('Cart Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('starts with empty cart', () => {
    const store = useCartStore()
    expect(store.items).toEqual([])
    expect(store.total).toBe(0)
  })

  it('adds item to cart', () => {
    const store = useCartStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50, quantite: 2 })
    expect(store.items).toHaveLength(1)
    expect(store.items[0].quantite).toBe(2)
  })

  it('updates item quantity', () => {
    const store = useCartStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50, quantite: 2 })
    store.updateQuantity(1, 5)
    expect(store.items[0].quantite).toBe(5)
  })

  it('removes item from cart', () => {
    const store = useCartStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50, quantite: 2 })
    store.removeItem(1)
    expect(store.items).toHaveLength(0)
  })

  it('calculates total correctly', () => {
    const store = useCartStore()
    store.addItem({ id: 1, nom: 'A', prix: 50, quantite: 2 })
    store.addItem({ id: 2, nom: 'B', prix: 30, quantite: 1 })
    expect(store.total).toBe(130)
  })

  it('clears cart', () => {
    const store = useCartStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50, quantite: 2 })
    store.clearCart()
    expect(store.items).toHaveLength(0)
  })
})
