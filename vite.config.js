import {resolve} from 'path';
import tailwindcss from 'tailwindcss'
import autoprefixer from 'autoprefixer'
import postcssImport from 'postcss-import';
import postcssNesting from 'postcss-nesting';
import postcssCustomMedia from 'postcss-custom-media';
import FastGlob from 'fast-glob'

const reload = {
    name: 'reload',
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
    plugins: [reload],
    css: {
        postcss: {
            plugins: [postcssImport, postcssNesting, postcssCustomMedia, tailwindcss, autoprefixer]
        }
    },
    server: {
        watch: {
            usePolling: true
        },
        hmr: {
            host: 'localhost'
        }
    },
    build: {
        manifest: true,
        outDir: "www",
        emptyOutDir: false,
        rollupOptions: {
            input: FastGlob.sync(['./src/**/*.js']).map(entry => resolve(process.cwd(), entry))
        }
    }
}
