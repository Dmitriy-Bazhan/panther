require('./bootstrap');
require('alpinejs');

import * as Vue from "vue";
import * as VueRouter from "vue-router";
import Test from './pages/test';

// const routes = [{ path: "/", component: Test }];
// const router = VueRouter.createRouter({
//     routes,
//     history: VueRouter.createWebHistory(),
// });



const app = Vue.createApp(Test);
// app.use(router);
app.mount("#app");



