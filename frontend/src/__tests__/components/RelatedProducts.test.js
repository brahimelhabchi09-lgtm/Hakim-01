import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import RelatedProducts from '../../components/product/RelatedProducts.vue'

describe('RelatedProducts', () => {
  it('renders related products', () => {
    const products = [
      { id: 1, nom: 'Product 1', slug: 'p1', prix: 10 },
      { id: 2, nom: 'Product 2', slug: 'p2', prix: 20 },
    ]
    const wrapper = mount(RelatedProducts, { props: { products } })
    expect(wrapper.text()).toContain('Product 1')
    expect(wrapper.text()).toContain('Product 2')
  })
})
