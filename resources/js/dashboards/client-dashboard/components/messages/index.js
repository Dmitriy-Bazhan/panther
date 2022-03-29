import template from './template.html';
import Chat from './Chat';
import Nurse from './Nurse'

export default {
    name: "Messages",
    template: template,
    props: ['user', 'data'],
    components: {
        'chat': Chat,
        'nurse': Nurse,
    },
    data() {
        return {
            chats: false,
            nurses: false,
            firstChat: null,
            haveNewMessages: [],
        }
    },
    mounted() {
        this.getPrivateChats();

        try {
            window.Echo.private('client-have-new-message.' + this.user.id)
                .listen('PrivateChat.ClientHaveNewMessage', (response) => {
                    this.emitter.emit('chat-have-unread-message', response.result.nurse_user_id);
                    this.getPrivateChats();
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        } catch (e) {
            console.log('Websockets not work');
        }
    },
    methods: {
        getPrivateChats() {
            axios.get('/dashboard/client-private-chats')
                .then((response) => {
                    this.chats = response.data.chats;
                    this.nurses = response.data.nurses;
                    this.haveNewMessages = response.data.haveNewMessages;
                    this.firstChat = Object.keys(this.chats)[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}
