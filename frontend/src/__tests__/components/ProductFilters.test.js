import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductFilters from '../../components/ui/ProductFilters.vue'

describe('ProductFilters', () => {
  it('renders search input', () => {
    const wrapper = mount(ProductFilters)
    expect(wrapper.find('input[type="search"]').exists()).toBe(true)
  })

  it('emits filter change', async () => {
    const wrapper = mount(ProductFilters)
    await wrapper.find('input[type="search"]').setValue('test')
    expect(wrapper.emitted('filter-change')).toBeTruthy()
  })
})
