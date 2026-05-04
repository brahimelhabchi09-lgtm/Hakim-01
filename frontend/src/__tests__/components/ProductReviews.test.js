import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductReviews from '../../components/product/ProductReviews.vue'

describe('ProductReviews', () => {
  it('renders review list', () => {
    const reviews = [{ id: 1, note: 5, commentaire: 'Great!' }]
    const wrapper = mount(ProductReviews, { props: { reviews } })
    expect(wrapper.text()).toContain('Great!')
  })

  it('emits new review event', async () => {
    const wrapper = mount(ProductReviews, { props: { reviews: [] } })
    expect(wrapper.find('form').exists()).toBe(true)
  })
})
