import template from './wrapper.html';
import AdminHeader from './Header';
import LeftPanel from "./LeftPanel";
import Notification from "../admin-dashboard/Notification";
// import TestChat from "../../TestChat";

export default {
    name: 'admin-dashboard',
    props: ['user', 'data'],
    template: template,
    components: {
      'admin-header' : AdminHeader,
      'left-panel' : LeftPanel,
      'notification': Notification
      // 'test-chat' : TestChat,
    },
    mounted() {
        console.log(this.data);
    }
}
