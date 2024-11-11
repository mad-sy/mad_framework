/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.twig",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}
