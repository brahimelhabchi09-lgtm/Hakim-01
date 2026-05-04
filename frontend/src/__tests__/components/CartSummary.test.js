import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import CartSummary from '../../components/cart/CartSummary.vue'

describe('CartSummary', () => {
  it('renders total', () => {
    const wrapper = mount(CartSummary, { props: { total: 150.50 } })
    expect(wrapper.text()).toContain('150.50')
  })

  it('renders item count', () => {
    const wrapper = mount(CartSummary, { props: { total: 100, itemCount: 3 } })
    expect(wrapper.text()).toContain('3')
  })

  it('renders checkout button', () => {
    const wrapper = mount(CartSummary, { props: { total: 100 } })
    expect(wrapper.find('button').exists()).toBe(true)
  })
})
