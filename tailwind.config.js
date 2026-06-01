/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        'light-bg': '#f9fafb',
        'light-card': '#ffffff',
        'light-border': '#e5e7eb',
        'light-text': '#111827',
        'light-subtext': '#6b7280',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}

