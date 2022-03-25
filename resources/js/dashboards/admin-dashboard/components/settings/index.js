import template from './template.html';
import Menu from './Menu';
import HearAboutUs from "./HearAboutUs";

export default {
    name: "Settings",
    template: template,
    components: {
        menu_settings: Menu,
        hear_about_us: HearAboutUs,
    },
    props: ['user', 'data'],
    data() {
        return {
            active_menu: 'other',
            hear_about_us: [],
        }
    },
    mounted() {
        this.getHearAboutUs();

        this.emitter.on('show-settings-menu-component', e => {
            this.active_menu = e;
        });
    },
    methods: {
        getHearAboutUs(){
            axios.get('/dashboard/admin/hear-about-us')
                .then((response) => {
                    console.log(response.data.hear_about_us);
                    this.hear_about_us = response.data.hear_about_us;
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }

}
