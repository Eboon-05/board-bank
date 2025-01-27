import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', ...defaultTheme.fontFamily.sans],
                rubik: ['Rubik', ...defaultTheme.fontFamily.sans],
                geo: ['Geo', ...defaultTheme.fontFamily.mono],
            },
        },
        colors: {
            ...colors,
            primary: 'hsl(11, 87, 60)',
            'primary-light': 'hsl(18, 100, 80)',
            'secondary': 'hsl(0, 0, 85)',
            'light-gray': 'hsl(0, 0, 95)',
        }
    },

    plugins: [forms],
};
