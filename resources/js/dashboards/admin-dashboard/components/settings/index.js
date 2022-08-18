import template from './template.html';
import Menu from './Menu';
import HearAboutUs from "./HearAboutUs";
import SiteSettings from "./SiteSettings";
import PaymentApiSettings from "./PaymentApiSettings";
import TypeOfLearning from "./TypeOfLearning";
import TimeIntervals from "./TimeIntervals";
import MailTemplate from "./MailTemplate";
import Faq from "./Faq";

export default {
    name: "Settings",
    template: template,
    components: {
        menu_settings: Menu,
        hear_about_us: HearAboutUs,
        site_settings: SiteSettings,
        payment_api_settings: PaymentApiSettings,
        type_of_learning: TypeOfLearning,
        time_intervals: TimeIntervals,
        mail_template: MailTemplate,
        faq: Faq,
    },
    props: ['user', 'data'],
    data() {
        return {
            active_menu: 'payment_api_settings',
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
