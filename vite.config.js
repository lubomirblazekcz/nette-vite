const reload = {
    name: 'reload',
    handleHotUpdate({ file, server }) {
        if (file.endsWith(".php") || file.endsWith(".latte")) {
            server.ws.send({
                type: 'full-reload',
                path: '*',
            });
        }
    }
}

export default {
    plugins: [reload],
    build: {
        manifest: true,
        outDir: "www",
        emptyOutDir: false,
        rollupOptions: {
            input: '/src/main.js'
        }
    }
}