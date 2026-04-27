import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                    DEFAULT: '#2F4DD3', // Warna utama FSTI ITK (DOMINAN)
                    hover: '#00509D',   // VIVID AZURE (Pendukung/Hover)
                    dark: '#003566',    // DARK AZURE (Aksen gelap)
                },
                secondary: {
                    DEFAULT: '#FDC500', // YELLOW
                    hover: '#FFDF3A',   // LIGHT YELLOW
                },
                accent: {
                    DEFAULT: '#D9FFFE', // LIGHT CYAN
                }
            }
        },
    },

    plugins: [forms, typography],
};