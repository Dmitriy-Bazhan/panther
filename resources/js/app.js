require('./bootstrap');
require('alpinejs');

import * as Vue from 'vue';
import * as VueI18n from 'vue-i18n'
import App from './pages/app/index';
import AdminDashboard from './dashboards/admin-dashboard/index';
import ClientDashboard from './dashboards/client-dashboard/index';
import NurseDashboard from './dashboards/nurse-dashboard/index';
import publicRouter from './routes/router';
import adminRouter from './routes/admin-router';
import clientRouter from './routes/client-router';
import nurseRouter from './routes/nurse-router';
import messages from './locale';

const i18n = VueI18n.createI18n({
    locale: window.locale,
    messages
});

import mitt from 'mitt';
const emitter = mitt();

if (window.dashboard === 'dashboard') {

    const dashboard = Vue.createApp({});
    dashboard.use(i18n);
    dashboard.config.globalProperties.emitter = emitter;

    if (window.guard === 'admin') {
        dashboard.component('dashboard', AdminDashboard);
        dashboard.use(adminRouter);
    }

    if (window.guard === 'client') {
        dashboard.component('dashboard', ClientDashboard);
        dashboard.use(clientRouter);
    }

    if (window.guard === 'nurse') {
        dashboard.component('dashboard', NurseDashboard);
        dashboard.use(nurseRouter);

    }
    dashboard.mount("#dashboard");

} else {

    const app = Vue.createApp({});
    app.component('app', App);
    app.use(publicRouter);
    app.use(i18n);
    app.config.globalProperties.emitter = emitter;
    app.mount("#app");

}




