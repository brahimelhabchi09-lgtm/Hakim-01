import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductInfo from '../../components/product/ProductInfo.vue'

describe('ProductInfo', () => {
  const product = { id: 1, nom: 'Test', slug: 'test', prix: 99, stock: 10, description: 'Desc' }

  it('renders product name and price', () => {
    const wrapper = mount(ProductInfo, { props: { product } })
    expect(wrapper.text()).toContain('Test')
    expect(wrapper.text()).toContain('99')
  })

  it('emits add to cart event', async () => {
    const wrapper = mount(ProductInfo, { props: { product } })
    await wrapper.find('button').trigger('click')
    expect(wrapper.emitted('add-to-cart')).toBeTruthy()
  })
})
