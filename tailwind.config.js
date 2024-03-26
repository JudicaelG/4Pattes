/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {},
    colors: {
      'text': '#050316',
      'background': '#fffafa',
      'primary': '#b60707',
      'secondary': '#ffdbdb',
      'accent': '#ff3d3d',
     },
  },
  plugins: [],
}

