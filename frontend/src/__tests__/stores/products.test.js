import { describe, it, expect, beforeEach, vi } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'
import { useProductsStore } from '../../stores/products'

vi.mock('../../services/api', () => ({
  default: {
    get: vi.fn(),
    post: vi.fn(),
  },
}))

describe('Products Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
  })

  it('initializes with empty products', () => {
    const store = useProductsStore()
    expect(store.products).toEqual([])
    expect(store.loading).toBe(false)
  })

  it('sets filters', () => {
    const store = useProductsStore()
    store.setFilters({ category_id: 1, min_price: 10 })
    expect(store.filters.category_id).toBe(1)
    expect(store.filters.min_price).toBe(10)
  })

  it('sets sort order', () => {
    const store = useProductsStore()
    store.setSort('price_asc')
    expect(store.sortBy).toBe('price_asc')
  })

  it('updates pagination', () => {
    const store = useProductsStore()
    store.setPagination({ current_page: 2, last_page: 5, total: 100 })
    expect(store.pagination.current_page).toBe(2)
  })
})
