import FastGlob from 'fast-glob'
import { resolve } from 'path';

import tailwindcss from 'tailwindcss'
import tailwindcssNesting from 'tailwindcss/nesting/index.js'
import autoprefixer from 'autoprefixer'
import postcssImport from 'postcss-import';
import postcssNesting from 'postcss-nesting';
import postcssCustomMedia from 'postcss-custom-media';
import vue from '@vitejs/plugin-vue'

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

const assets = (url) => {
    return {
        name: 'asset-base-url',
        enforce: 'post',
        transform: (code) => {
            code = code.replace(/(from |import\()("|'|`)(\/src|~?@|\/@fs\/@)\/(.*?)\.(svg|png|mp3|mp4)/g, `$1$2${url}/src/$4.$5?import=`)
            code = code.replace(/(?<!local)(\/src|~?@|\/@fs\/@)\/(.*?)\.(svg|png|mp3|mp4)/g, `${url}/src/$2.$3`)
            return {
                code,
                map: null,
            }
        }
    }
}

export default {
    plugins: [vue(), assets(`http://localhost:3000`), reload],
    css: {
        postcss: {
            plugins: [postcssImport, tailwindcssNesting(postcssNesting), postcssCustomMedia, tailwindcss, autoprefixer]
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
            input: FastGlob.sync(['./src/scripts/*.js', './src/styles/*.css']).map(entry => resolve(process.cwd(), entry))
        }
    }
}
