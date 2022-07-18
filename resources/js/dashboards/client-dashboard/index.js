import template from './wrapper.html';
import Header from "../components/Header";
import LeftPanel from "../client-dashboard/LeftPanel";
import ResponseSuccessTrue from "../components/ResponseSuccessTrue";

export default {
    name: 'dashboard',
    props: ['user', 'data'],
    template: template,
    components: {
        'pt-header' : Header,
        'left-panel' : LeftPanel,
        'response-success-true': ResponseSuccessTrue,
    },data() {
        return {
            showAlarmNewMessage: false,
            response_success_true: false,
        }
    },
    mounted() {
        this.emitter.on('response-success-true', e => {
            this.response_success_true = true;
            setTimeout(() => {
                this.response_success_true = false;
            },2000);
        });

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

