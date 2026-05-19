/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#6366f1',
        secondary: '#8b5cf6',
        accent: '#ec4899',
        dark: '#1a1a2e',
        darker: '#0f0f1e',
        card: '#2d2d44',
        border: '#3a3a52',
      },
      backgroundImage: {
        'gradient-primary': 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)',
        'gradient-success': 'linear-gradient(135deg, #10b981 0%, #14b8a6 100%)',
        'gradient-danger': 'linear-gradient(135deg, #ef4444 0%, #ec4899 100%)',
        'gradient-warning': 'linear-gradient(135deg, #f59e0b 0%, #f97316 100%)',
        'gradient-info': 'linear-gradient(135deg, #3b82f6 0%, #06b6d4 100%)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

