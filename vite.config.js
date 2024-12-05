import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],

    build: {
        outDir: "dist", // Ganti output ke "dist"
        emptyOutDir: true, // Bersihkan folder dist sebelum build baru
    },
});
