import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import BaseModal from '../../components/ui/BaseModal.vue'

describe('BaseModal', () => {
  it('renders when visible', () => {
    const wrapper = mount(BaseModal, { props: { visible: true }, slots: { default: 'Content' } })
    expect(wrapper.text()).toContain('Content')
  })

  it('does not render when hidden', () => {
    const wrapper = mount(BaseModal, { props: { visible: false } })
    expect(wrapper.find('.modal-content').exists()).toBe(false)
  })

  it('emits close event on overlay click', async () => {
    const wrapper = mount(BaseModal, { props: { visible: true } })
    await wrapper.find('.modal-overlay').trigger('click')
    expect(wrapper.emitted('close')).toBeTruthy()
  })
})
