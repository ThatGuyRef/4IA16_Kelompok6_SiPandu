import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Public Sans', 'sans-serif'],
            },
            colors: {
                // Match the provided dashboard snippet palette
                'background-light': '#f5f8f7',
                'background-dark': '#0f231c',
                primary: {
                    DEFAULT: '#019863',
                    50: '#ebfff6',
                    100: '#cffde7',
                    200: '#a0f6cf',
                    300: '#6aeab4',
                    400: '#35d997',
                    500: '#019863',
                    600: '#007a4f',
                    700: '#026042',
                    800: '#064d37',
                    900: '#083f2f',
                },
                accent: {
                    50: '#fff8f5',
                    100: '#ffefe6',
                    200: '#ffd6bf',
                    300: '#ffb391',
                    400: '#ff8a63',
                    500: '#ff6a3d',
                    600: '#ff4f1f',
                    700: '#cc3f19',
                    800: '#992f12',
                    900: '#661f0b',
                }
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                    lg: '4rem',
                    xl: '6rem',
                },
            },
            boxShadow: {
                card: 'var(--card-shadow)',
            },
        },
    },

    plugins: [forms],
};
