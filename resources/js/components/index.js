import Icon from './Icon/Icon';
import Input from './Input/Input';
import Accordeon from './Accordeon/Accordeon';
import Preloader from './Preloader/Preloader';

import MainSlider from './PageBlocks/HeadBlock';
import MainUsers from './PageBlocks/UsersBlock';
import Faq from './PageBlocks/FaqBlock';
import AboutBlock from './PageBlocks/AboutBlock';
import BenefitsBlock from './PageBlocks/BenefitsBlock';
import InfoBlock from './PageBlocks/InfoBlock';

import VueGoogleMaps from '@fawmi/vue-google-maps'
import {Swiper, SwiperSlide} from 'swiper/vue';
import * as VueI18n from 'vue-i18n'
import vSelect from "vue-select";
import Datepicker from '@vuepic/vue-datepicker';
import 'vue-universal-modal/dist/index.css';
import VueUniversalModal from 'vue-universal-modal';
import MediaPopup from './Media/Media';

import '@vuepic/vue-datepicker/dist/main.css';
import 'swiper/css';
import "vue-select/dist/vue-select.css";
import 'viewerjs/dist/viewer.css';

import AdminDashboard from '../dashboards/admin-dashboard/index';
import ClientDashboard from '../dashboards/client-dashboard/index';
import NurseDashboard from '../dashboards/nurse-dashboard/index';

let i18n = VueI18n.createI18n({
    locale: window.locale,
    silentTranslationWarn: true,
});

let Components

if (window.dashboard === 'dashboard') {
    Components = {
        install(Vue) {
            axios.get('/get-translate')
                .then((response) => {
                    if (response.data.success) {
                        for (let key in response.data.langs) {
                            i18n.global.setLocaleMessage(key, response.data.langs[key])
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
            Vue.use(i18n);
            Vue.component('media-popup', MediaPopup);
            Vue.component('pt-icon', Icon);
            Vue.component("v-select", vSelect);

            Vue.use(VueUniversalModal, {
                teleportTarget: '#modals'
            })
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
} else {
    Components = {
        install(Vue) {
            axios.get('/get-translate')
                .then((response) => {
                    if (response.data.success) {
                        for (let key in response.data.langs) {
                            i18n.global.setLocaleMessage(key, response.data.langs[key])
                        }
                    }
                })
                .catch((error) => {
                    console.log(error);
                });

            Vue.use(VueGoogleMaps, {
                load: {
                    key: '',
                    libraries: "places"
                },
                autobindAllEvents: true,
            })
            Vue.use(VueUniversalModal, {
                teleportTarget: '#modals'
            })
            Vue.use(i18n);
            Vue.component('pt-preloader', Preloader);
            Vue.component('pt-icon', Icon);
            Vue.component('pt-input', Input);
            Vue.component('pt-accordeon', Accordeon);
            Vue.component('swiper-slide', SwiperSlide);
            Vue.component('swiper', Swiper);

            Vue.component('head-block', MainSlider);
            Vue.component('users-block', MainUsers);
            Vue.component('faq-block', Faq);
            Vue.component('about-block', AboutBlock);
            Vue.component('benefits-block', BenefitsBlock);
            Vue.component('info-block', InfoBlock);

            Vue.component("v-select", vSelect);
            Vue.component('Datepicker', Datepicker);
        }
    };
}

export default Components;
