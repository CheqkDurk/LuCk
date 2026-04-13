/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'cheqk-black': '#0a0a0a',
        'cheqk-charcoal': '#1a1a1a',
        'cheqk-gold': '#d4af37',
        'cheqk-silver': '#c0c0c0',
        'cheqk-dark-gray': '#2a2a2a',
      },
      fontFamily: {
        'luxury': ['Playfair Display', 'serif'],
        'modern': ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}
