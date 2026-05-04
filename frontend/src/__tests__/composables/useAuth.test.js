import { describe, it, expect, vi, beforeEach } from 'vitest'
import { useAuth } from '../../composables/useAuth'

vi.mock('../../stores/auth', () => ({
  useAuthStore: vi.fn(() => ({
    setUser: vi.fn(),
    logout: vi.fn(),
    user: null,
  })),
}))

describe('useAuth Composable', () => {
  it('exposes login function', () => {
    const { login } = useAuth()
    expect(typeof login).toBe('function')
  })

  it('exposes register function', () => {
    const { register } = useAuth()
    expect(typeof register).toBe('function')
  })

  it('exposes logout function', () => {
    const { logout } = useAuth()
    expect(typeof logout).toBe('function')
  })
})
