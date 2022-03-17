import template from './wrapper.html';
import ClientHeader from "../client-dashboard/Header";
import LeftPanel from "../client-dashboard/LeftPanel";

export default {
    name: 'dashboard',
    props: ['user', 'data'],
    template: template,
    components: {
        'client-header' : ClientHeader,
        'left-panel' : LeftPanel,
    },data() {
        return {
            showAlarmNewMessage: false,
        }
    },
    mounted() {
        this.emitter.on('disable-show-alarm-new-message', e => {
            this.showAlarmNewMessage = false;
        });

        if(this.data.have_new_message){
            this.showAlarmNewMessage = true;
        }

        try {
            window.Echo.private('client-have-new-message.' + this.user.id)
                .listen('PrivateChat.ClientHaveNewMessage', (response) => {
                    this.showAlarmNewMessage = true;
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        } catch (e) {
            console.log('Websockets not work');
        }
    }
}

