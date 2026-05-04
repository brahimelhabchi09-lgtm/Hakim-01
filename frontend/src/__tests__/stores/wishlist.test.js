import { describe, it, expect, beforeEach } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'
import { useWishlistStore } from '../../stores/wishlist'

describe('Wishlist Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('starts empty', () => {
    const store = useWishlistStore()
    expect(store.items).toEqual([])
  })

  it('adds item to wishlist', () => {
    const store = useWishlistStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50 })
    expect(store.items).toHaveLength(1)
  })

  it('removes item from wishlist', () => {
    const store = useWishlistStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50 })
    store.removeItem(1)
    expect(store.items).toHaveLength(0)
  })

  it('toggles item in wishlist', () => {
    const store = useWishlistStore()
    store.toggleItem({ id: 1, nom: 'Product', prix: 50 })
    expect(store.items).toHaveLength(1)
    store.toggleItem({ id: 1, nom: 'Product', prix: 50 })
    expect(store.items).toHaveLength(0)
  })

  it('checks if item is in wishlist', () => {
    const store = useWishlistStore()
    store.addItem({ id: 1, nom: 'Product', prix: 50 })
    expect(store.isInWishlist(1)).toBe(true)
    expect(store.isInWishlist(2)).toBe(false)
  })
})
