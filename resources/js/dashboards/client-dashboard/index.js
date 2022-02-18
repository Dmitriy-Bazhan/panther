import template from './wrapper.html';
import ClientHeader from "../client-dashboard/Header";
import LeftPanel from "../client-dashboard/LeftPanel";

export default {
    name: 'dashboard',
    props: ['user'],
    template: template,
    components: {
        'client-header' : ClientHeader,
        'left-panel' : LeftPanel,
    },
    mounted() {
        console.log(this.user);
    }
}

