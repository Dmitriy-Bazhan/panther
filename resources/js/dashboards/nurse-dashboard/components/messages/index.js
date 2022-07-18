// import template from './template.html';
import template from './template_new.html';
// import Chat from './Chat';
import Chat from './ChatNew';
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
            clients: false,
            client_id: null,
            haveNewMessages: [],
            comments: [],
            firstChat: null,
        }
    },
    mounted() {
        this.getPrivateChats();

        this.emitter.on('show-chat', e => {
            if(e !== this.index){
                let push = {
                    client_id: e,
                    haveNewMessages: this.haveNewMessages
                }
                this.emitter.emit('get-message', push);
            }
        });

        try {
            window.Echo.private('nurse-have-new-message.' + this.user.id)
                .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                    this.emitter.emit('chat-have-unread-message', response.result.client_user_id);
                    if(this.clients.length === 0) {
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
                    this.clients = response.data.clients;
                    console.log(this.clients);
                    this.haveNewMessages = response.data.haveNewMessages;
                    this.client_id = Object.keys(this.clients)[0];
                    this.firstChat = this.client_id;
                    let e = {
                        client_id: this.client_id,
                        haveNewMessages: this.haveNewMessages
                    }
                    this.emitter.emit('get-message', e);
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}

