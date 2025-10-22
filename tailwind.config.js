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
                primary: {
                    50: '#f5faff',
                    100: '#e8f4ff',
                    200: '#cfe9ff',
                    300: '#b5ddff',
                    400: '#7ec8ff',
                    500: '#3faeff',
                    600: '#0a93f6',
                    700: '#0572c4',
                    800: '#045a9a',
                    900: '#044066',
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
        },
    },

    plugins: [forms],
};
