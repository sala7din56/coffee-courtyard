/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.{html,php,js}',
  ],
  darkMode: "class",
  theme: {
      extend: {
          colors: {
              "primary": "#dda15e",
              "background-light": "#fefae0",
              "background-dark": "#201912",
              "text-primary-light": "#283618",
              "text-secondary-light": "#606c38",
              "text-accent-light": "#bc6c25",
              "text-primary-dark": "#fefae0",
              "text-secondary-dark": "#a3b18a",
              "text-accent-dark": "#dda15e"
          },
          fontFamily: {
              "display": ["Plus Jakarta Sans", "sans-serif"]
          },
          borderRadius: {
              "DEFAULT": "0.25rem",
              "lg": "0.5rem",
              "xl": "0.75rem",
              "full": "9999px"
          },
      },
  },
  plugins: [],
}