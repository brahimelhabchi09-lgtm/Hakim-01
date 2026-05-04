import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductCard from '../../components/ui/ProductCard.vue'

describe('ProductCard', () => {
  const product = {
    id: 1,
    nom: 'Test Product',
    slug: 'test-product',
    prix: 99.99,
    image: '/test.jpg',
    marque: { nom: 'Test Brand' },
  }

  it('renders product name', () => {
    const wrapper = mount(ProductCard, { props: { product } })
    expect(wrapper.text()).toContain('Test Product')
  })

  it('renders product price', () => {
    const wrapper = mount(ProductCard, { props: { product } })
    expect(wrapper.text()).toContain('99.99')
  })

  it('renders brand name', () => {
    const wrapper = mount(ProductCard, { props: { product } })
    expect(wrapper.text()).toContain('Test Brand')
  })
})
