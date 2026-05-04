import { describe, it, expect, beforeEach } from 'vitest'
import { createPinia, setActivePinia } from 'pinia'
import { useAuthStore } from '../../stores/auth'

describe('Auth Store', () => {
  beforeEach(() => {
    setActivePinia(createPinia())
    localStorage.clear()
  })

  it('starts not authenticated', () => {
    const store = useAuthStore()
    expect(store.isAuthenticated).toBe(false)
    expect(store.user).toBeNull()
  })

  it('sets user on login', () => {
    const store = useAuthStore()
    const user = { id: 1, email: 'test@test.com', is_admin: false }
    store.setUser(user, 'token123')
    expect(store.isAuthenticated).toBe(true)
    expect(store.user).toEqual(user)
    expect(store.token).toBe('token123')
  })

  it('clears user on logout', () => {
    const store = useAuthStore()
    store.setUser({ id: 1, email: 'test@test.com', is_admin: false }, 'token123')
    store.logout()
    expect(store.isAuthenticated).toBe(false)
    expect(store.user).toBeNull()
    expect(store.token).toBeNull()
  })

  it('persists token in localStorage', () => {
    const store = useAuthStore()
    store.setUser({ id: 1, email: 'test@test.com', is_admin: false }, 'token123')
    expect(localStorage.getItem('auth_token')).toBe('token123')
  })
})
