<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 chat-wrapper">
                <div v-if="comments.length > 0" v-for="comment in comments">
                    <div v-if="comment.client_sent === 'yes'" class="chat-client-message-wrapper">
                        <span class="chat-client-name">
                            {{ comment.user_name }}
                        </span>
                        <br>
                        <span class="chat-client-message">
                            {{ comment.message }}
                        </span>
                        <br>
                        <span class="chat-client-date">
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
                            {{ formatDate(comment.created_at) }}
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
                {{ $t('message') }}:
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" v-model="privateMessage"><br>
                <input type="file" id="file" ref="file"><br>
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
        name: "ChatNew",
        props: ['user'],
        data() {
            return {
                privateMessage: '',
                showMarkIsReadBlock: false,
                comments: [],
                client_id: null,
                haveNewMessages: null
            }
        },
        mounted() {
            this.emitter.on('get-message', e => {
                this.client_id = e.client_id;
                this.haveNewMessages = e.haveNewMessages;
                this.showMarkIsReadBlock = false;
                this.checkChatsHaveUnreadMessages();
                this.getComments();
                this.listenBroadcast();
            });

            this.emitter.on('chat-have-unread-message', e => {
                if (e == this.client_id) {
                    this.showMarkIsReadBlock = true;
                }
            });
        },
        methods: {
            listenBroadcast(){
                try {
                    window.Echo.private('client-between-nurse.' + this.user.id + '.' + this.client_id)
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
            getComments(){
                axios.get('/dashboard/nurse-private-chats/get-current-chat/'+ this.user.id + '/' + this.client_id)
                    .then((response) => {
                        if(response.data.success){
                            this.comments = response.data.messages;
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            markAsReadThisChat(){
                axios.post('/dashboard/nurse-private-chats/mark-as-read', {
                    'nurse_id' :this.user.id,
                    'client_id': this.client_id,
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
                let message = new FormData();
                let file = null;
                if(this.$refs.file.files[0] !== undefined){
                    file = this.$refs.file.files[0]
                }

                message.append('file', file);
                message.append('client_id',this.client_id,);
                message.append('nurse_id', this.user.id,);
                message.append('privateMessage', this.privateMessage,);

                axios.post('/dashboard/nurse-private-chats', message ,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }).then((response) => {
                    if (response.data.success) {
                        this.privateMessage = '';
                        document.getElementById('file').value = null;
                    }else{
                        console.log(response.data.errors);
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
                    if(this.haveNewMessages[el] == this.client_id){
                        this.emitter.emit('chat-have-unread-message', this.client_id);
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
        background: lightcyan;
        padding: 10px;
    }

    .chat-client-message-wrapper {
        background: #85acff;
        border: solid 1px #405dff;
        padding: 10px;
        border-radius: 10px;
        width: 75%;
        margin-bottom: 10px;
    }

    .chat-client-name {
        font-size: 14px;
        font-weight: 700;
        color: #051dff;
    }

    .chat-client-message {
        font-size: 14px;
        font-weight: 700;
        color: #6500ff;
    }

    .chat-client-date {
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
