import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import OrderConfirmation from '../../components/checkout/OrderConfirmation.vue'

describe('OrderConfirmation', () => {
  it('renders order number', () => {
    const wrapper = mount(OrderConfirmation, {
      props: { orderNumber: 'CMD-000001', total: 150 }
    })
    expect(wrapper.text()).toContain('CMD-000001')
    expect(wrapper.text()).toContain('150')
  })
})
