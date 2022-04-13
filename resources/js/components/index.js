import Icon from './Icon/Icon';
import { Swiper, SwiperSlide } from 'swiper/vue';
import * as VueI18n from 'vue-i18n'
import messages from '../locale';
import 'swiper/css';

import AdminDashboard from '../dashboards/admin-dashboard/index';
import ClientDashboard from '../dashboards/client-dashboard/index';
import NurseDashboard from '../dashboards/nurse-dashboard/index';

const i18n = VueI18n.createI18n({
    locale: window.locale,
    messages
});


let Components

if (window.dashboard === 'dashboard') {
    Components = {
        install(Vue) {
            Vue.use(i18n);
            if (window.guard === 'admin') {
                Vue.component('dashboard', AdminDashboard);
            }

            if (window.guard === 'client') {
                Vue.component('dashboard', ClientDashboard);
            }

            if (window.guard === 'nurse') {
                Vue.component('dashboard', NurseDashboard);

            }
        }
    };
}
else{
    Components = {
        install(Vue) {
            Vue.use(i18n);
            Vue.component('pt-icon', Icon);
            Vue.component('swiper-slide', SwiperSlide);
            Vue.component('swiper', Swiper);
        }
    };
}

export default Components;
