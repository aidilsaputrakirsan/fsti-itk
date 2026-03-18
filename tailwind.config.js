import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';


/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'optimus': ['"Optimus Princeps"', 'serif'],
                'public-sans': ['"Public Sans"', 'sans-serif'],
            },

            colors: {
                primary: {
                    DEFAULT: '#2F4DD3', // Warna utama FSTI ITK
                    hover: '##00509D',   // Warna lebih gelap untuk efek hover
                }
            }
        },
    },

    plugins: [forms],
};