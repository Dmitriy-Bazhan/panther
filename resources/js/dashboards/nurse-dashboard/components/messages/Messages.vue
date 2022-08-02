<template>
    <div class="pt-messages--tabs">
        <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'active'}" @click.prevent="activateTab('active')">
            All
        </button>
        <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'new'}" @click.prevent="activateTab('new')">
            new
        </button>
        <button class="pt-messages--tabs-btn" :class="{active: activeTab === 'deleted'}" @click.prevent="activateTab('deleted')">
            deleted
        </button>
    </div>
    <div class="pt-messages">
        <div class="pt-messages--panel">
            <pt-search></pt-search>
            <div v-if="clients" v-for="(client, index) in filteredClients">
                <client :index="index" :client="client" :firstChat="firstChat"></client>
            </div>
            <h3 class="pt-mt-5" v-show="Object.keys(filteredClients).length === 0">
                Empty
            </h3>
        </div>
        <div class="pt-messages--body">
            <chat :user="user" :clients="clients" :chat="chat"></chat>
        </div>
    </div>
</template>

<script>
import Chat from './Chat';
import Client from "./Client";

export default {
    name: "MessagesClient",
    props: ['user', 'data'],
    components: {
        'chat': Chat,
        'client': Client,
    },
    data() {
        return {
            search: '',
            clients: false,
            filteredClients: false,
            activeTab: 'active',
            client_id: null,
            haveNewMessages: [],
            comments: [],
            chat: false,
            firstChat: null,
        }
    },
    mounted() {
        this.getPrivateChats();

        this.emitter.on('show-chat', e => {
            if(e !== this.client_id){
                let push = {
                    client_id: e,
                    haveNewMessages: this.haveNewMessages
                }
                this.emitter.emit('get-message', push);
                window.Echo.private('client-between-nurse.' + this.user.id + '.' + this.client_id)
                    .stopListening('PrivateChat.ClientNurseSentMessage')
            }
            this.client_id = e
        });

        this.emitter.on('change-message-status', e => {
            this.activateTab(e)
        });

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.filterClients()
        })

        try {
            window.Echo.private('nurse-have-new-message.' + this.user.id)
                .listen('PrivateChat.NurseHaveNewMessage', (response) => {
                    this.emitter.emit('chat-have-unread-message', response.result.client_user_id);
                    this.getPrivateChats();
                    // if(this.clients.length === 0) {
                    //     this.getPrivateChats();
                    // }
                }).error((error) => {
                console.log('chat test log 2')
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        } catch (e) {
            console.log('Websockets not work');
        }
    },
    methods: {
        activateTab(n) {
            let self = this
            let result = {}
            if(n){
                self.activeTab = n
            }

            if(self.activeTab === 'active'){
                _.forEach(self.clients, function (e, key){
                    if(e.chat.status === 'active'){
                        result[key] = e
                    }
                })
            }
            if(self.activeTab === 'deleted'){
                _.forEach(self.clients, function (e, key){
                    if(e.chat.status === 'deleted'){
                        result[key] = e
                    }
                })
            }
            else{
                _.forEach(self.clients, function (e, key){
                    //let res2 = e[0].last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1
                    if(e.count > 0){
                        result[key] = e
                    }
                })
            }

            this.filteredClients = result
        },
        filterClients() {
            let self = this
            let result = {}
            _.forEach(self.clients, function (e, key){
                let res1 = e[0].first_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1
                let res2 = e[0].last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1

                if(res1 || res2){
                    result[key] = e
                }
            })
            this.filteredClients = result
        },
        getPrivateChats() {
            let self = this
            axios.get('/dashboard/nurse-private-chats')
                .then((response) => {
                    this.clients = response.data.clients;
                    this.filteredClients = response.data.clients;
                    this.haveNewMessages = response.data.haveNewMessages;
                    if(!this.client_id){
                        this.client_id = Object.keys(this.clients)[0];
                    }
                    this.chat = response.data.clients[this.client_id].chat;
                    this.firstChat = this.client_id;
                    let e = {
                        client_id: this.client_id,
                        haveNewMessages: this.haveNewMessages
                    }
                    this.emitter.emit('get-message', e);
                    this.activateTab()
                    if(self.$route.params.chatId){
                        self.emitter.emit('show-chat', self.$route.params.chatId);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}


</script>

