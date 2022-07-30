import template from './wrapper.html';
import AdminHeader from './Header';
import Header from "../components/Header";
import LeftPanel from "./LeftPanel";
import Notification from "../admin-dashboard/Notification";
import ResponseSuccessTrue from "../components/ResponseSuccessTrue";


// import TestChat from "../../TestChat";

export default {
    name: 'admin-dashboard',
    props: ['user', 'data'],
    template: template,
    data() {
        return {
            response_success_true: false,
        }
    },
    components: {
        'pt-header' : Header,
        'admin-header': AdminHeader,
        'left-panel': LeftPanel,
        'notification': Notification,
        'response-success-true': ResponseSuccessTrue,
        // 'test-chat' : TestChat,
    },
    mounted() {
        console.log(this.data);
        this.emitter.on('response-success-true', e => {
            this.response_success_true = true;
            setTimeout(() => {
                this.response_success_true = false;
            }, 2000);
        });
    }
}
