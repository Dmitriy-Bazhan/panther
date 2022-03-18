<template>
    <div class="container-fluid" v-if="showChat">
        <div class="row">
            <div class="col-12 chat-wrapper">
                <div v-if="comments.length > 0" v-for="comment in comments">
                    <div v-if="comment.client_sent === 'yes'" class="chat-nurse-message-wrapper">
                        <span class="chat-nurse-name">
                            {{ comment.user_name }}
                        </span>
                        <br>
                        <span class="chat-nurse-message">
                            {{ comment.message }}
                        </span>
                        <br>
                        <span class="chat-nurse-date">
                            {{ formatDate(comment.created_at)  + ' ' + comment.status }}
                        </span>
                    </div>

                    <div v-else class="nurse-client-message-wrapper">
                        <span class="nurse-client-name">
                            {{ comment.user_name }}
                        </span>
                        <br>
                        <span class="nurse-client-message">
                            {{ comment.message }}
                        </span>
                        <br>
                        <span class="nurse-client-date">
                            {{ formatDate(comment.created_at) + ' ' + comment.status }}
                        </span>

                    </div>
                </div>
                <div v-if="chat.length > 0" v-for="comment in chat">
                    <div v-if="comment.client_sent === 'yes'" class="chat-nurse-message-wrapper">
                        <span class="chat-nurse-name">
                            {{ comment.user_name }}
                        </span>
                        <br>
                        <span class="chat-nurse-message">
                            {{ comment.message }}
                        </span>
                        <br>
                        <span class="chat-nurse-date">
                            {{ formatDate(comment.created_at)  + ' ' + comment.status }}
                        </span>
                    </div>

                    <div v-else class="nurse-client-message-wrapper">
                        <span class="nurse-client-name">
                            {{ comment.user_name }}
                        </span>
                        <br>
                        <span class="nurse-client-message">
                            {{ comment.message }}
                        </span>
                        <br>
                        <span class="nurse-client-date">
                            {{ formatDate(comment.created_at) + ' ' + comment.status }}
                        </span>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row" v-if="showMarkIsReadBlock">
            <div class="col-4">
                {{ $t('chat_have_unread_messages') }}
            </div>
            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="markAsReadThisChat()">{{ $t('mark_as_read') }}</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2">
                Message:
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" v-model="privateMessage">
            </div>
            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="sendPrivateMessage()">{{ $t('send') }}</button>
            </div>
        </div>
        <br>
        <br>
    </div>
</template>

<script>
    export default {
        name: "Chat",
        props: ['user', 'index', 'chat' ,'firstChat', 'haveNewMessages'],
        data() {
            return {
                comments: [],
                privateMessage: '',
                showChat: false,
                showMarkIsReadBlock: false,
            }
        },
        mounted() {
            this.checkChatsHaveUnreadMessages();

            if(this.firstChat === this.index){
                this.showChat = true;
            }

            this.emitter.on('show-chat', e => {
                if(e === this.index){
                    this.showChat = true;
                }else{
                    this.showChat = false;
                }
            });

            this.emitter.on('chat-have-unread-message', e => {
                if (e == this.index) {
                    this.showMarkIsReadBlock = true;
                }
            });

            try {
                window.Echo.private('client-between-nurse.' + this.index + '.' + this.user.id)
                    .listen('PrivateChat.ClientNurseSentMessage', (response) => {
                        let message = {
                            'user_name': response.result.user_name,
                            'message': response.result.message,
                            'client_sent': response.result.client_sent,
                            'nurse_sent': response.result.client_sent,
                            'created_at': response.result.created_at,
                            'status': response.result.status,
                        };
                        this.comments.unshift(message);
                    }).error((error) => {
                    console.log('ERROR IN SOCKETS CONNTECT : ' + error);
                });
            } catch (e) {
                console.log('Websockets not work');
            }


        },
        methods: {
            markAsReadThisChat(){
                axios.post('/dashboard/client-private-chats/mark-as-read', {
                    'client_id' :this.user.id,
                    'nurse_id': this.index,
                }).then((response) => {
                    if(response.data.success === true){
                        this.showMarkIsReadBlock = false;
                        this.emitter.emit('disable-alert-on-nurse-name', this.index);
                        if(response.data.have_new_message === 'yes'){
                            this.emitter.emit('disable-show-alarm-new-message');
                        }
                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            sendPrivateMessage() {
                axios.post('/dashboard/client-private-chats', {
                    'client_id' :this.user.id,
                    'nurse_id': this.index,
                    'privateMessage': this.privateMessage
                }).then((response) => {
                    if(response.data.success){
                        this.privateMessage = '';
                    }
                }).catch((error) => {
                    console.log(error);
                });
            },
            formatDate(date) {
                let a = String(date).split('T');
                return a[0] + ' ' + String(a[1].split('.')[0]);
            },
            checkChatsHaveUnreadMessages(){
                for(let el in this.haveNewMessages){
                    if(this.haveNewMessages[el] == this.index){
                        this.emitter.emit('chat-have-unread-message', this.index);
                        this.showMarkIsReadBlock = true;
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .chat-wrapper {
        height: 400px;
        overflow: auto;
    }

    .chat-nurse-message-wrapper {
        background: #85acff;
        border: solid 1px #405dff;
        padding: 10px;
        border-radius: 10px;
        width: 75%;
        margin-bottom: 10px;
    }

    .chat-nurse-name {
        font-size: 14px;
        font-weight: 700;
        color: #051dff;
    }

    .chat-nurse-message {
        font-size: 14px;
        font-weight: 700;
        color: #6500ff;
    }

    .chat-nurse-date {
        font-size: 10px;
        font-weight: 700;
        color: #051dff;
    }

    .nurse-client-message-wrapper {
        background: #97ff05;
        border: solid 1px #1eff14;
        padding: 10px;
        border-radius: 10px;
        width: 75%;
        margin-left: 25%;
        margin-bottom: 10px;
    }

    .nurse-client-name {
        font-size: 14px;
        font-weight: 700;
        color: #029612;
    }

    .nurse-client-message {
        font-size: 14px;
        font-weight: 700;
        color: #10700a;
    }

    .nurse-client-date {
        font-size: 10px;
        font-weight: 700;
        color: #0b5716;
    }
</style>
