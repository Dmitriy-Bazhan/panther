import template from './template.html';
import Chat from './Chat';
import Client from "./Client";

export default {
    name: "MessagesClient",
    template: template,
    props: ['user', 'data'],
    components: {
        'chat': Chat,
        'client': Client,
    },
    data() {
        return {
            chats: false,
            clients: false,
            firstChat: null,
            haveNewMessages: [],
        }
    },
    mounted() {
        this.getPrivateChats();

        try {
            window.Echo.private('nurse-have-new-message.' + this.user.id)
                .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                    this.emitter.emit('chat-have-unread-message', response.result.client_user_id);
                    if(this.chats.length === 0) {
                        this.getPrivateChats();
                    }
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        } catch (e) {
            console.log('Websockets not work');
        }
    },
    methods: {
        getPrivateChats() {
            axios.get('/dashboard/nurse-private-chats')
                .then((response) => {
                    this.chats = response.data.chats;
                    this.clients = response.data.clients;
                    this.haveNewMessages = response.data.haveNewMessages;
                    this.firstChat = Object.keys(this.chats)[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}

