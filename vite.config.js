import FastGlob from 'fast-glob'
import { resolve } from 'node:path'
import tailwindcss from '@tailwindcss/vite'

const reload = {
    handleHotUpdate({ file, server }) {
        if (!file.includes('temp') && file.endsWith(".php") || file.endsWith(".latte")) {
            server.ws.send({
                type: 'full-reload',
                path: '*',
            });
        }
    }
}

export default {
    plugins: [tailwindcss(), reload],
    server: {
        watch: {
            usePolling: true
        },
        hmr: {
            host: 'localhost'
        }
    },
    build: {
        manifest: 'manifest.json',
        outDir: "www",
        emptyOutDir: false,
        modulePreload: false,
        assetsInlineLimit: 0,
        rollupOptions: {
            input: FastGlob.sync(['./src/scripts/*.js', './src/styles/*.css'])
                .map(entry => resolve(process.cwd(), entry))
        }
    }
}
