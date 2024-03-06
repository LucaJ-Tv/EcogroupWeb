/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}"
  ],
  theme: {
    extend: {
      colors: {
        "site-primary": "rgb(22 101 52)",
        "site-secondary": "rgb(22 163 74)",
        "site-error": "#D73A49",
      }
    },
    fontFamily: {
      Roboto: ["Roboto, sans-serif"],
      Inter: ["Inter, sans-serif"]
    },
    container:{
      padding: "2rem",
      center: true
    }
  },
  plugins: [],
}

