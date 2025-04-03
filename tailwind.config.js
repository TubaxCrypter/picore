import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui'; // DaisyUI'yi ekliyoruz

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
            },
        },
    },

    plugins: [forms,daisyui],
    daisyui: {
        themes: ["light", "dark", "retro", "cyberpunk", "valentine", "aqua", "synthwave"],
        darkTheme: "dark",
        base: true,
        styled: true,
        utils: true,
        logs: true,
      },
};
