//--------------------------------------------------------------------------
// Tailwind configuration
//--------------------------------------------------------------------------
//
// Use the Tailwind configuration to completely define the current sites
// design system by adding and extending to Tailwinds default utility
// classes. Various aspects of the config are split in multiple files.
//

module.exports = {
    // Configure files to scan for utility classes (JIT).
    content: [
        "./resources/views/**/*.blade.php",
        "./resources/views/**/*.html",
        "./resources/js/**/*.js",
        "./resources/**/*.antlers.html",
        "./resources/**/*.antlers.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.vue",
        "./content/**/*.md",
        "./vendor/studio1902/**/*.blade.php",
        "./vendor/studio1902/**/*.html",
        "./vendor/studio1902/**/*.js",
        "./node_modules/flowbite/**/*.js",
        "./node_modules/tailwindcss-animated/src/index.js",
    ],
    theme: {
        extend: {
            listStyleType: {
                square: "square",
                roman: "upper-roman",
            },
            backgroundColor: {
                primary: "var(--primary-color)",
                "primary-600": "var(--primary-color-600)",
                "primary-700": "var(--primary-color-700)",
                "primary-800": "var(--primary-color-800)",
                "primary-900": "var(--primary-color-900)",
                secondary: "var(--secondary-color)",
                "secondary-600": "var(--secondary-color-600)",
                "secondary-700": "var(--secondary-color-700)",
                "secondary-800": "var(--secondary-color-800)",
                "secondary-900": "var(--secondary-color-900)",
            },
            textColor: {
                primary: "var(--primary-color)",
                "primary-600": "var(--primary-color-600)",
                "primary-700": "var(--primary-color-700)",
                "primary-800": "var(--primary-color-800)",
                "primary-900": "var(--primary-color-900)",
                secondary: "var(--secondary-color)",
                "secondary-600": "var(--secondary-color-600)",
                "secondary-700": "var(--secondary-color-700)",
                "secondary-800": "var(--secondary-color-800)",
                "secondary-900": "var(--secondary-color-900)",
            },
            borderColor: {
                primary: "var(--primary-color)",
                "primary-600": "var(--primary-color-600)",
                "primary-700": "var(--primary-color-700)",
                "primary-800": "var(--primary-color-800)",
                "primary-900": "var(--primary-color-900)",
                secondary: "var(--secondary-color)",
                "secondary-600": "var(--secondary-color-600)",
                "secondary-700": "var(--secondary-color-700)",
                "secondary-800": "var(--secondary-color-800)",
                "secondary-900": "var(--secondary-color-900)",
            },
            fontWeight: {
                thinbold: "650",
            },
        },
        fontSize: {
            xs: "0.6rem",
            sm: "0.8rem",
            base: "1rem",
            xl: "1.25rem",
            "2xl": "1.563rem",
            "3xl": "1.953rem",
            "4xl": "36px",
            "5xl": "36px",
            "6xl": "3.752rem",
            "7xl": "50px",
        },
        screens: {
            sm: "640px",
            // => @media (min-width: 640px) { ... }

            md: "768px",
            // => @media (min-width: 768px) { ... }

            lg: "1024px",
            // => @media (min-width: 1024px) { ... }

            xl: "1280px",
            // => @media (min-width: 1280px) { ... }

            "2xl": "1536px",
            // => @media (min-width: 1536px) { ... }
        },
        fontFamily: {
            body: [
                "Inter",
                "ui-sans-serif",
                "system-ui",
                "-apple-system",
                "system-ui",
                "Segoe UI",
                "Roboto",
                "Helvetica Neue",
                "Arial",
                "Noto Sans",
                "sans-serif",
                "Apple Color Emoji",
                "Segoe UI Emoji",
                "Segoe UI Symbol",
                "Noto Color Emoji",
            ],
            sans: [
                "Inter",
                "ui-sans-serif",
                "system-ui",
                "-apple-system",
                "system-ui",
                "Segoe UI",
                "Roboto",
                "Helvetica Neue",
                "Arial",
                "Noto Sans",
                "sans-serif",
                "Apple Color Emoji",
                "Segoe UI Emoji",
                "Segoe UI Symbol",
                "Noto Color Emoji",
            ],
        },
    },
    plugins: [  require("@tailwindcss/typography"),
                require("flowbite/plugin"),
                require('@tailwindcss/aspect-ratio'),
                require('tailwindcss-animated'),
            ],
    safelist: [],
};
