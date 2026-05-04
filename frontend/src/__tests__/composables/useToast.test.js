import { describe, it, expect } from 'vitest'
import { useToast } from '../../composables/useToast'

describe('useToast Composable', () => {
  it('adds toast notification', () => {
    const { addToast, toasts } = useToast()
    addToast('Success!', 'success')
    expect(toasts.value).toHaveLength(1)
    expect(toasts.value[0].message).toBe('Success!')
  })

  it('removes toast by id', () => {
    const { addToast, removeToast, toasts } = useToast()
    addToast('Test', 'info')
    const id = toasts.value[0].id
    removeToast(id)
    expect(toasts.value).toHaveLength(0)
  })

  it('clears all toasts', () => {
    const { addToast, clearToasts, toasts } = useToast()
    addToast('One', 'success')
    addToast('Two', 'error')
    clearToasts()
    expect(toasts.value).toHaveLength(0)
  })
})
