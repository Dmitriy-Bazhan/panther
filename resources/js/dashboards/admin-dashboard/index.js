import template from './wrapper.html';
import AdminHeader from './Header';
import LeftPanel from "./LeftPanel";

export default {
    name: 'admin-dashboard',
    props: ['user'],
    template: template,
    components: {
      'admin-header' : AdminHeader,
      'left-panel' : LeftPanel,
    },
    mounted() {
        console.log(this.user);
    }
}
