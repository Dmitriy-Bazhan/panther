import template from './template.html';
import Menu from './Menu';
import HearAboutUs from "./HearAboutUs";
import SiteSettings from "./SiteSettings";
import TypeOfLearning from "./TypeOfLearning";

export default {
    name: "Settings",
    template: template,
    components: {
        menu_settings: Menu,
        hear_about_us: HearAboutUs,
        site_settings: SiteSettings,
        type_of_learning: TypeOfLearning,
    },
    props: ['user', 'data'],
    data() {
        return {
            active_menu: 'type_of_learning',
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
