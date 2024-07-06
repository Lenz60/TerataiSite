import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
// import { createI18n } from "vue-i18n";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// import { allCountries } from "country-region-data";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// console.log(allCountries);

//? To make app lighter this i18n is deleted
//? because the vue-warn will  gone if this goes production
// const messages = allCountries.reduce((messages, country) => {
//     messages[country[0]] = country[0];
//     return messages;
// }, {});
// console.log(messages);

// const i18n = createI18n({
//     locale: "en", // set locale
//     messages: {
//         en: messages,
//         // other locales...
//     },
// });
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return (
            createApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue)
                // .use(vueCountryRegionSelect)
                // .use(i18n)
                .mount(el)
        );
    },
    progress: {
        color: "#4B5563",
    },
});
