import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import AdminSidebar from '../../components/admin/AdminSidebar.vue'

describe('AdminSidebar', () => {
  it('renders navigation links', () => {
    const wrapper = mount(AdminSidebar)
    expect(wrapper.find('nav').exists()).toBe(true)
  })

  it('renders dashboard link', () => {
    const wrapper = mount(AdminSidebar)
    expect(wrapper.text()).toContain('Dashboard')
  })
})
