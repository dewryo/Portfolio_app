import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig(({ command }) => ({
    base: command === 'build' ? 'https://eduforumapp.com/' : '/', // 本番環境のベースURLを設定
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    build: {
        // 本番ビルドの設定
        minify: 'terser', // または 'esbuild' を使用する
        terserOptions: {
            compress: {
                drop_console: true, // コンソールログを削除
            },
        },
    },
    server: command === 'serve' ? {
        // 開発環境の設定
        host: true,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
        },
    } : undefined, // 本番環境ではサーバ設定を無効化
}));
