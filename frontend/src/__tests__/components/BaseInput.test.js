import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import BaseInput from '../../components/ui/BaseInput.vue'

describe('BaseInput', () => {
  it('renders with label', () => {
    const wrapper = mount(BaseInput, { props: { label: 'Email' } })
    expect(wrapper.text()).toContain('Email')
  })

  it('renders input element', () => {
    const wrapper = mount(BaseInput)
    expect(wrapper.find('input').exists()).toBe(true)
  })

  it('shows error message', () => {
    const wrapper = mount(BaseInput, { props: { error: 'Required' } })
    expect(wrapper.text()).toContain('Required')
  })

  it('binds value prop', () => {
    const wrapper = mount(BaseInput, { props: { modelValue: 'test' } })
    expect(wrapper.find('input').element.value).toBe('test')
  })

  it('emits input event', async () => {
    const wrapper = mount(BaseInput)
    await wrapper.find('input').setValue('hello')
    expect(wrapper.emitted('update:modelValue')).toBeTruthy()
  })
})
