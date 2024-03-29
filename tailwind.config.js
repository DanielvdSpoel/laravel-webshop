const colors = require('tailwindcss/colors')

module.exports = {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        './vendor/filament/**/*.blade.php',
        "./vendor/awcodes/filament-curator/resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                danger: colors.red,
                primary: colors.indigo,
                success: colors.green,
                warning: colors.yellow,
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
