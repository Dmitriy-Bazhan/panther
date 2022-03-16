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
    }, data() {
        return {
            showAlarmNewMessage: false,
        }
    },
    mounted() {
        this.emitter.on('disable-show-alarm-new-message', e => {
            this.showAlarmNewMessage = false;
        });

        try {
            window.Echo.private('nurse-have-new-message.' + this.user.id)
                .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                    this.showAlarmNewMessage = true;
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        } catch (e) {
            console.log('Websockets not work');
        }
    }
}
