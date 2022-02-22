import template from './wrapper.html';
import AdminHeader from './Header';
import LeftPanel from "./LeftPanel";
// import TestChat from "../../TestChat";

export default {
    name: 'admin-dashboard',
    props: ['user', 'data'],
    template: template,
    components: {
      'admin-header' : AdminHeader,
      'left-panel' : LeftPanel,
      // 'test-chat' : TestChat,
    },
    mounted() {
        console.log(this.user);
    }
}
