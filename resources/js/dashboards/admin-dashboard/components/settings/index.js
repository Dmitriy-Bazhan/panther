import template from './template.html';
import Menu from './Menu';
import HearAboutUs from "./HearAboutUs";
import SiteSettings from "./SiteSettings";

export default {
    name: "Settings",
    template: template,
    components: {
        menu_settings: Menu,
        hear_about_us: HearAboutUs,
        site_settings: SiteSettings,
    },
    props: ['user', 'data'],
    data() {
        return {
            active_menu: 'hear_about_us',
        }
    },
    mounted() {
        this.emitter.on('show-settings-menu-component', e => {
            this.active_menu = e;
        });
    },
    methods: {

    }

}
