import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import CartItem from '../../components/cart/CartItem.vue'

describe('CartItem', () => {
  const item = { id: 1, nom: 'Product', prix: 50, quantite: 2, image: '/test.jpg' }

  it('renders item name', () => {
    const wrapper = mount(CartItem, { props: { item } })
    expect(wrapper.text()).toContain('Product')
  })

  it('renders item subtotal', () => {
    const wrapper = mount(CartItem, { props: { item } })
    expect(wrapper.text()).toContain('100')
  })

  it('emits remove event', async () => {
    const wrapper = mount(CartItem, { props: { item } })
    await wrapper.find('[data-testid="remove"]').trigger('click')
    expect(wrapper.emitted('remove')).toBeTruthy()
  })

  it('emits quantity change', async () => {
    const wrapper = mount(CartItem, { props: { item } })
    await wrapper.find('[data-testid="quantity"]').setValue(5)
    expect(wrapper.emitted('update:quantity')).toBeTruthy()
  })
})
