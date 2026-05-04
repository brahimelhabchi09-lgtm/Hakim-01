import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductCardSkeleton from '../../components/ui/ProductCardSkeleton.vue'

describe('ProductCardSkeleton', () => {
  it('renders placeholder elements', () => {
    const wrapper = mount(ProductCardSkeleton)
    expect(wrapper.classes()).toContain('animate-pulse')
  })
})
