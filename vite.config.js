import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'public/assets/vendor/apexcharts/apexcharts.min.js',
                'public/assets/vendor/chart.js/chart.min.js',
                'public/assets/vendor/echarts/echarts.min.js',
                'public/assets/vendor/quill/quill.min.js',
                'public/assets/vendor/simple-datatables/simple-datatables.js',
                'public/assets/vendor/tinymce/tinymce.min.js',
                'public/assets/vendor/php-email-form/validate.js',
                'assets/js/main.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
