import template from './template.html';
import Chat from './Chat';
import Client from "./Client";

export default {
    name: "MessagesClient",
    template: template,
    props: ['user', 'data'],
    components: {
        'chat': Chat,
        'client' : Client,
    },
    data() {
        return {
            chats: false,
            clients: false,
            firstChat: null,
        }
    },
    mounted() {
        this.getPrivateChats();
        this.emitter.emit('disable-show-alarm-new-message');

        try {
            window.Echo.private('nurse-have-new-message.' + this.user.id)
                .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                    if(!this.chats){
                        this.getPrivateChats();
                    }else{
                        console.log('Chats exists');
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
                    this.firstChat = Object.keys(this.chats)[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}

