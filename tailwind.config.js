/*
 * Copyright (c) 2021 WüSpace e. V. <kontakt@wuespace.de>
 */

module.exports = {
  purge: [
    './**/*.php'
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    fontFamily: {
      'headline': ['Comfortaa', 'Roboto', 'Arial', 'sans-serif'],
      'body': ['Roboto', 'Arial', 'sans-serif'],
    },
    extend: {
      colors: {
        primary: '#452897'
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
