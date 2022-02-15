import Header from "./Header.vue";
import Footer from "./Footer.vue";


const Layouts = {
    install(Vue) {
        Vue.component("pf-header", Header);
        Vue.component("pf-footer", Footer);
    }
};

export default Layouts;
