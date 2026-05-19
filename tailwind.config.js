/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#0066cc',
        secondary: '#6c757d',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
