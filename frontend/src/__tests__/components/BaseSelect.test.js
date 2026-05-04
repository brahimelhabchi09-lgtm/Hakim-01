import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import BaseSelect from '../../components/ui/BaseSelect.vue'

describe('BaseSelect', () => {
  it('renders with options', () => {
    const options = [{ value: 1, label: 'One' }, { value: 2, label: 'Two' }]
    const wrapper = mount(BaseSelect, { props: { options } })
    expect(wrapper.findAll('option').length).toBe(3)
  })

  it('emits change event', async () => {
    const options = [{ value: 1, label: 'One' }]
    const wrapper = mount(BaseSelect, { props: { options } })
    await wrapper.find('select').setValue(1)
    expect(wrapper.emitted('update:modelValue')).toBeTruthy()
  })
})
