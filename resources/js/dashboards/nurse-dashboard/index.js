import template from './wrapper.html';
import NurseHeader from "../nurse-dashboard/Header";
import LeftPanel from "../nurse-dashboard/LeftPanel";
import Notification from "./Notification";
// import TestChat from "../../TestChat";

export default {
    name: 'dashboard',
    props: ['user', 'data'],
    template: template,
    components: {
        'nurse-header': NurseHeader,
        'left-panel': LeftPanel,
        'notification': Notification
        // 'test-chat' : TestChat,
    },
    mounted() {
        // console.log(this.user);
    }
}
