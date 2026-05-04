import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import StarRating from '../../components/ui/StarRating.vue'

describe('StarRating', () => {
  it('renders correct number of stars', () => {
    const wrapper = mount(StarRating, { props: { rating: 4 } })
    expect(wrapper.findAll('.star').length).toBe(5)
  })

  it('emits rating change on click', async () => {
    const wrapper = mount(StarRating)
    await wrapper.findAll('.star')[2].trigger('click')
    expect(wrapper.emitted('update:rating')).toBeTruthy()
  })

  it('displays rating value', () => {
    const wrapper = mount(StarRating, { props: { rating: 3.5 } })
    expect(wrapper.text()).toContain('3.5')
  })
})
