import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ToastNotification from '../../components/ui/ToastNotification.vue'

describe('ToastNotification', () => {
  it('renders toasts', () => {
    const toasts = [{ id: 1, message: 'Test', type: 'success' }]
    const wrapper = mount(ToastNotification, { props: { toasts } })
    expect(wrapper.text()).toContain('Test')
  })

  it('dismisses toast on click', async () => {
    const toasts = [{ id: 1, message: 'Test', type: 'success' }]
    const wrapper = mount(ToastNotification, { props: { toasts } })
    await wrapper.find('[data-testid="dismiss"]').trigger('click')
    expect(wrapper.emitted('dismiss')).toBeTruthy()
  })
})
