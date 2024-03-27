/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
    colors: {
      'text': '#260000',
      'background': '#FFF5F2',
      'primary': '#B50707',
      'secondary': '#910202',
      'accent': '#E0453C',
      'button-menu': '#F6887A',
     }
  },
  plugins: [],
}

