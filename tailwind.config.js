import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'bssn-purple': '#3A0CA3',
                'bssn-purple-dark': '#2A0878',
                'bssn-pink': '#F0427D',
                'bssn-dark': '#0E0B1F',
            },
        },
    },

    plugins: [forms],
};
