import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import StatsCard from '../../components/admin/StatsCard.vue'

describe('StatsCard', () => {
  it('renders title and value', () => {
    const wrapper = mount(StatsCard, {
      props: { title: 'Revenue', value: 5000, icon: 'dollar' }
    })
    expect(wrapper.text()).toContain('Revenue')
    expect(wrapper.text()).toContain('5000')
  })
})
