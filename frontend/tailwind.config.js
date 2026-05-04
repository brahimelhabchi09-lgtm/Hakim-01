/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      colors: {
        bg: {
          primary: '#050505',
          secondary: '#0f0f0f',
          card: '#171717',
          elevated: '#222222',
          hover: '#2d2d2d',
        },
        accent: {
          primary: '#f97316',
          secondary: '#fb923c',
          DEFAULT: '#f97316',
        },
        text: {
          primary: '#fff7ed',
          secondary: '#fdba74',
          muted: '#c2410c',
        },
        border: {
          DEFAULT: '#7c2d12',
          light: '#9a3412',
        },
        wolf: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          500: '#06b6d4',
          600: '#0891b2',
          700: '#0e7490',
          900: '#082f49',
        },
      },
      fontFamily: {
        display: ['Space Grotesk', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
        accent: ['Outfit', 'sans-serif'],
      },
      boxShadow: {
        sm: '0 2px 8px rgba(0, 0, 0, 0.5)',
        md: '0 4px 16px rgba(0, 0, 0, 0.6)',
        lg: '0 8px 32px rgba(0, 0, 0, 0.7)',
        glow: '0 0 20px rgba(249, 115, 22, 0.45)',
        'glow-cyan': '0 0 20px rgba(251, 146, 60, 0.35)',
        'inner-glow': 'inset 0 0 20px rgba(249, 115, 22, 0.18)',
      },
      transitionDuration: {
        'fast': '150ms',
        'normal': '250ms',
        'slow': '400ms',
      },
      keyframes: {
        'float': {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        'pulse-glow': {
          '0%, 100%': { boxShadow: '0 0 20px rgba(249, 115, 22, 0.45), inset 0 0 20px rgba(249, 115, 22, 0.15)' },
          '50%': { boxShadow: '0 0 30px rgba(251, 146, 60, 0.6), inset 0 0 30px rgba(251, 146, 60, 0.25)' },
        },
        'shimmer': {
          '0%': { backgroundPosition: '-1000px 0' },
          '100%': { backgroundPosition: '1000px 0' },
        },
        'scale-in': {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        'fade-slide-up': {
          '0%': { opacity: '0', transform: 'translateY(16px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        'tilt': {
          '0%, 100%': { transform: 'rotate(0deg) scale(1)' },
          '50%': { transform: 'rotate(-2deg) scale(1.01)' },
        },
      },
      animation: {
        'float': 'float 3s ease-in-out infinite',
        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
        'shimmer': 'shimmer 3s linear infinite',
        'scale-in': 'scale-in 0.3s ease-out',
        'fade-slide-up': 'fade-slide-up 0.5s ease-out',
        'tilt': 'tilt 5s ease-in-out infinite',
      },
    },
  },
  plugins: [],
}
