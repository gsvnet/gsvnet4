const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    darkMode: "class",
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gsv-purple': '#780125',
                'gsv-purple-dark': '#3e0014'
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
