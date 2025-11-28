import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/layout.css',
                'resources/css/components.css',
                'resources/css/profile.css',
                'resources/css/login.css',
                'resources/css/admin.css',
                'resources/css/user.css',
                'resources/css/kriteria.css',
                'resources/css/alternatif.css',
                'resources/css/penilaian.css',
                'resources/css/wp.css',
                'resources/css/borda.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
