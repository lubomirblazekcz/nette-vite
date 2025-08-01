import { defineConfig } from 'vite'
import nette from '@nette/vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
	plugins: [
		tailwindcss(),
		nette({
			entry: ['scripts/main.js', 'styles/main.css'],
		}),
	],

	build: {
		emptyOutDir: true,
		assetsInlineLimit: 0,
	},

	css: {
		devSourcemap: true,
	},
});
