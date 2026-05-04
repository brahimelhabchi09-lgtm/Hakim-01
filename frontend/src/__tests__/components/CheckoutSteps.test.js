import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import CheckoutSteps from '../../components/checkout/CheckoutSteps.vue'

describe('CheckoutSteps', () => {
  it('renders all steps', () => {
    const steps = ['Cart', 'Shipping', 'Payment']
    const wrapper = mount(CheckoutSteps, { props: { steps, currentStep: 0 } })
    expect(wrapper.text()).toContain('Cart')
    expect(wrapper.text()).toContain('Shipping')
    expect(wrapper.text()).toContain('Payment')
  })

  it('highlights current step', () => {
    const steps = ['Cart', 'Shipping', 'Payment']
    const wrapper = mount(CheckoutSteps, { props: { steps, currentStep: 1 } })
    expect(wrapper.text()).toBeTruthy()
  })
})
