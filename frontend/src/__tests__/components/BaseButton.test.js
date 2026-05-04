import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import BaseButton from '../../components/ui/BaseButton.vue'

describe('BaseButton', () => {
  it('renders with default props', () => {
    const wrapper = mount(BaseButton, { slots: { default: 'Click me' } })
    expect(wrapper.text()).toContain('Click me')
  })

  it('renders as button element', () => {
    const wrapper = mount(BaseButton)
    expect(wrapper.element.tagName).toBe('BUTTON')
  })

  it('applies variant class', () => {
    const wrapper = mount(BaseButton, { props: { variant: 'primary' } })
    expect(wrapper.classes()).toContain('bg-primary')
  })

  it('applies size class', () => {
    const wrapper = mount(BaseButton, { props: { size: 'lg' } })
    expect(wrapper.classes()).toContain('px-6')
  })

  it('is disabled when prop is set', () => {
    const wrapper = mount(BaseButton, { props: { disabled: true } })
    expect(wrapper.element.disabled).toBe(true)
  })
})
