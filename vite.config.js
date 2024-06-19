import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";
import vue from '@vitejs/plugin-vue';


export default defineConfig({
    resolve: {
        alias: {
          vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    plugins: [
        laravel({
            input: [
                "resources/css/tailwind.css",
                 "resources/js/site.js",
                "resources/js/lazyload.js",
                 'resources/js/vue_site.js',
            ],
            refresh: true,
        }),
        vue(),
    ],
});
