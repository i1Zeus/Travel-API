import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import UnoCSS from "unocss/vite";

export default defineConfig({
    plugins: [
        UnoCSS({
            content: { filesystem: ["./resources/views/**/*.blade.php"] },
        }),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
