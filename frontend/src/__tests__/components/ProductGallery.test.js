import { describe, it, expect } from 'vitest'
import { mount } from '@vue/test-utils'
import ProductGallery from '../../components/product/ProductGallery.vue'

describe('ProductGallery', () => {
  it('renders main image', () => {
    const images = ['/img1.jpg', '/img2.jpg']
    const wrapper = mount(ProductGallery, { props: { images, mainImage: '/img1.jpg' } })
    expect(wrapper.find('img').exists()).toBe(true)
  })

  it('renders thumbnail list', () => {
    const images = ['/img1.jpg', '/img2.jpg', '/img3.jpg']
    const wrapper = mount(ProductGallery, { props: { images, mainImage: '/img1.jpg' } })
    expect(wrapper.findAll('img').length).toBeGreaterThan(1)
  })
})
