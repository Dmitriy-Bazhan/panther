require('./bootstrap');
require('alpinejs');

import * as Vue from 'vue';

import App from './pages/app/index';
import Store from './store/store';
import publicRouter from './routes/router';
import adminRouter from './routes/admin-router';
import clientRouter from './routes/client-router';
import nurseRouter from './routes/nurse-router';


// Install components and plugins
import Components from "./components";

const dasboardRoute = {
    'admin': adminRouter,
    'client': clientRouter,
    'nurse': nurseRouter,
}


import mitt from 'mitt';
const emitter = mitt();

if (window.dashboard === 'dashboard') {
    const dashboard = Vue.createApp({});
    dashboard.config.globalProperties.emitter = emitter;
    dashboard.use(Components);
    dashboard.use(Store)
    if(window.guard in dasboardRoute){
        dashboard.use(dasboardRoute[window.guard]);
    }
    dashboard.mount("#dashboard");

} else {
    const app = Vue.createApp({});
    app.component('app', App);
    app.use(Store)
    app.use(Components);
    app.use(publicRouter);
    app.config.globalProperties.emitter = emitter;
    app.mount("#app");

}




