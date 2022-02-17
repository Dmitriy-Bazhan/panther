require('./bootstrap');
require('alpinejs');

import * as Vue from "vue";
import * as VueI18n from 'vue-i18n'
import App from './App';
import Dashboard from './Dashboard'
import publicRouter from "./routes/router";
import Layouts from "./layouts";
import messages from './locale';

// if(window.guard)

const i18n = VueI18n.createI18n({
    locale: window.locale,
    messages
});

if(window.dashboard === 'dashboard'){
    const dashboard = Vue.createApp(Dashboard);
    dashboard.use(publicRouter);
    dashboard.use(Layouts);
    dashboard.mount("#dashboard");

}else{
    const app = Vue.createApp(App);
    app.use(publicRouter);
    app.use(Layouts);
    app.use(i18n);
    app.mount("#app");

}




