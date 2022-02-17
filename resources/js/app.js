require('./bootstrap');
require('alpinejs');

import * as Vue from "vue";
import * as VueI18n from 'vue-i18n'
import App from './App';
import AdminDashboard from './dashboards/admin-dashboard/index';
import ClientDashboard from './dashboards/client-dashboard/index';
import NurseDashboard from './dashboards/nurse-dashboard/index';
import publicRouter from "./routes/router";
import Layouts from "./layouts/app";
import messages from './locale';

const i18n = VueI18n.createI18n({
    locale: window.locale,
    messages
});

import mitt from 'mitt';
const emitter = mitt();

if (window.dashboard === 'dashboard') {

    if (window.guard === 'admin') {
        const dashboard = Vue.createApp({});
        dashboard.component('dashboard', AdminDashboard);
        dashboard.config.globalProperties.emitter = emitter;
        dashboard.mount("#dashboard");
    }

    if (window.guard === 'client') {
        const dashboard = Vue.createApp({});
        dashboard.component('dashboard', ClientDashboard);
        dashboard.config.globalProperties.emitter = emitter;
        dashboard.mount("#dashboard");
    }

    if (window.guard === 'nurse') {
        const dashboard = Vue.createApp({});
        dashboard.component('dashboard', NurseDashboard);
        dashboard.config.globalProperties.emitter = emitter;
        dashboard.mount("#dashboard");
    }

} else {

    const app = Vue.createApp(App);
    app.use(publicRouter);
    app.use(Layouts);
    app.use(i18n);
    app.config.globalProperties.emitter = emitter;
    app.mount("#app");

}




