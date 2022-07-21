import template from './template.html';
import Menu from './Menu';
import HearAboutUs from "./HearAboutUs";
import SiteSettings from "./SiteSettings";
import TypeOfLearning from "./TypeOfLearning";
import TimeIntervals from "./TimeIntervals";

export default {
    name: "Settings",
    template: template,
    components: {
        menu_settings: Menu,
        hear_about_us: HearAboutUs,
        site_settings: SiteSettings,
        type_of_learning: TypeOfLearning,
        time_intervals: TimeIntervals,
    },
    props: ['user', 'data'],
    data() {
        return {
            active_menu: 'time_intervals',
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
