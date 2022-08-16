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
            <div v-if="nurses" v-for="(nurse, index) in filteredNurses">
                <nurse :index="index" :nurse="nurse" :firstChat="firstChat"></nurse>
            </div>
            <h3 class="pt-mt-5" v-show="Object.keys(filteredNurses).length === 0">
                Empty
            </h3>
        </div>
        <div class="pt-messages--body">
            <chat :user="user" :nurses="nurses" :chat="chat"></chat>
        </div>
    </div>
</template>

<script>
import Chat from './Chat';
import Nurse from './Nurse'

export default {
    name: "MessagesClient",
    props: ['user', 'data'],
    components: {
        'chat': Chat,
        'nurse': Nurse,
    },
    data() {
        return {
            search: '',
            nurses: false,
            filteredNurses: false,
            activeTab: 'active',
            nurse_id: null,
            haveNewMessages: [],
            comments: [],
            chat: false,
            firstChat: null,
            type: false,
        }
    },
    mounted() {
        this.type = this.user.entity_type
        this.getPrivateChats();

        this.emitter.on('show-chat', e => {
            if(e !== this.nurse_id){
                let push = {
                    nurse_id: e,
                    haveNewMessages: this.haveNewMessages
                }
                this.emitter.emit('get-message', push);
                window.Echo.private('client-between-nurse.' + this.nurse_id + '.' + this.user.id)
                    .stopListening('PrivateChat.ClientNurseSentMessage')
            }
            this.nurse_id = e
        });

        this.emitter.on('change-message-status', e => {
            this.activateTab(e)
        });

        this.emitter.on('pt-search', (e) => {
            this.search = e
            this.filterUsers()
        })

        try {
            window.Echo.private('client-have-new-message.' + this.user.id)
                .listen('PrivateChat.ClientHaveNewMessage', (response) => {
                    this.emitter.emit('chat-have-unread-message', response.result.client_user_id);
                    this.getPrivateChats();
                    console.log('test')
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
                _.forEach(self.nurses, function (e, key){
                    if(e.chat.status === 'active'){
                        result[key] = e
                    }
                })
            }
            if(self.activeTab === 'deleted'){
                _.forEach(self.nurses, function (e, key){
                    if(e.chat.status === 'deleted'){
                        result[key] = e
                    }
                })
            }
            else{
                _.forEach(self.nurses, function (e, key){
                    //let res2 = e[0].last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1
                    if(e.count > 0){
                        result[key] = e
                    }
                })
            }

            this.filteredNurses = result
        },
        filterUsers() {
            let self = this
            let result = {}
            _.forEach(self.nurses, function (e, key){
                let res1 = e[0].first_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1
                let res2 = e[0].last_name.toLowerCase().indexOf(self.search.toLowerCase()) !== -1

                if(res1 || res2){
                    result[key] = e
                }
            })
            this.filteredNurses = result
        },
        getPrivateChats() {
            axios.get('/dashboard/client-private-chats')
                .then((response) => {
                    this.nurses = response.data.nurses;
                    this.haveNewMessages = response.data.haveNewMessages;

                    this.filteredNurses = response.data.nurses;
                    this.haveNewMessages = response.data.haveNewMessages;
                    if(!this.nurse_id){
                        this.nurse_id = Object.keys(this.nurses)[0];
                    }
                    this.chat = response.data.nurses[this.nurse_id].chat;
                    this.firstChat = this.nurse_id;
                    let e = {
                        nurse_id: this.nurse_id,
                        haveNewMessages: this.haveNewMessages
                    }
                    this.emitter.emit('get-message', e);
                    this.activateTab()
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
}


</script>

