require('./bootstrap');
require('alpinejs');

import * as Vue from "vue";

import App from './App';
import router from "./routes/router";
import Layouts from "./layouts";



const app = Vue.createApp(App);
app.use(router);
app.use(Layouts);
app.mount("#app");



