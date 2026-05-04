import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import AddressForm from '../../components/checkout/AddressForm.vue'

describe('AddressForm', () => {
  it('renders address fields', () => {
    const wrapper = mount(AddressForm)
    expect(wrapper.find('input[name="street"]').exists()).toBe(true)
    expect(wrapper.find('input[name="city"]').exists()).toBe(true)
  })

  it('emits submit event', async () => {
    const wrapper = mount(AddressForm)
    await wrapper.find('input[name="street"]').setValue('123 Test St')
    await wrapper.find('input[name="city"]').setValue('Test City')
    await wrapper.find('button[type="submit"]').trigger('submit.prevent')
    expect(wrapper.emitted('submit')).toBeTruthy()
  })
})
