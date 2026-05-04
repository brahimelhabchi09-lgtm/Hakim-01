import { describe, it, expect, vi } from 'vitest'
import { useWishlist } from '../../composables/useWishlist'

vi.mock('../../stores/wishlist', () => ({
  useWishlistStore: vi.fn(() => ({
    addItem: vi.fn(),
    removeItem: vi.fn(),
    toggleItem: vi.fn(),
    isInWishlist: vi.fn(),
    items: [],
  })),
}))

describe('useWishlist Composable', () => {
  it('exposes toggleWishlist function', () => {
    const { toggleWishlist } = useWishlist()
    expect(typeof toggleWishlist).toBe('function')
  })

  it('exposes isInWishlist function', () => {
    const { isInWishlist } = useWishlist()
    expect(typeof isInWishlist).toBe('function')
  })
})
