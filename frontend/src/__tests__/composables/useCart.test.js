import { describe, it, expect, vi } from 'vitest'
import { useCart } from '../../composables/useCart'

vi.mock('../../stores/cart', () => ({
  useCartStore: vi.fn(() => ({
    addItem: vi.fn(),
    removeItem: vi.fn(),
    updateQuantity: vi.fn(),
    clearCart: vi.fn(),
    items: [],
    total: 0,
    count: 0,
  })),
}))

describe('useCart Composable', () => {
  it('exposes addToCart function', () => {
    const { addToCart } = useCart()
    expect(typeof addToCart).toBe('function')
  })

  it('exposes removeFromCart function', () => {
    const { removeFromCart } = useCart()
    expect(typeof removeFromCart).toBe('function')
  })

  it('exposes clearCart function', () => {
    const { clearCart } = useCart()
    expect(typeof clearCart).toBe('function')
  })
})
