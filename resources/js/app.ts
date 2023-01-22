import "../css/app.css"

import { createApp, h, DefineComponent } from "vue"
import { createInertiaApp } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import { trail } from "momentum-trail"
//@ts-ignore
import routes from "./routes/routes.json"

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "Laravel"

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")) as Promise<DefineComponent>,
    setup({ el, App, props, plugin }) {
        createApp(() => h(App, props))
            .use(plugin)
            .use(trail, { routes })
            .mount(el)
    },
    progress: { color: "#4B5563" },
})
