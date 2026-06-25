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
                travel: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                },
                sand: {
                    50: '#faf8f5',
                    100: '#f5f0e8',
                    200: '#ebe3d5',
                },
                accent: {
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#ea580c',
                },
            },
            boxShadow: {
                'card': '0 4px 24px rgba(14, 165, 233, 0.08), 0 1px 3px rgba(0,0,0,0.04)',
                'card-hover': '0 12px 40px rgba(14, 165, 233, 0.15), 0 4px 12px rgba(0,0,0,0.06)',
                'float': '0 20px 60px rgba(14, 165, 233, 0.12), 0 8px 24px rgba(0,0,0,0.08)',
                'auth': '0 25px 50px -12px rgba(14, 165, 233, 0.18), 0 12px 24px rgba(0,0,0,0.06)',
            },
            backgroundImage: {
                'hero-travel': "url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?auto=format&fit=crop&w=1920&q=80')",
                'auth-travel': "url('https://images.unsplash.com/photo-1488085061387-422e29b40080?auto=format&fit=crop&w=1920&q=80')",
                'cta-travel': "url('https://images.unsplash.com/photo-1526772662000-3f88f10405ff?auto=format&fit=crop&w=1920&q=80')",
                'panel-light': "url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1920&q=80')",
            },
        },
    },

    plugins: [forms],
};
