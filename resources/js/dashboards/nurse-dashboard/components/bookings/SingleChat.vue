<template>
    <div>
        <div class="row">
            <div class="col-2">
                {{ $t('chat') }}:
            </div>
            <div class="col-10 chat-wrapper" v-if="comments.length > 0">
                <div v-for="comment in comments">
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
                            {{ formatDate(comment.created_at) }}
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
        <div class="row">
            <div class="col-2">
                {{ $t('message') }}:
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" v-model="privateMessage">
            </div>
            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="sendPrivateMessage()">{{ $t('send') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SingleChat",
        props: ['nurse', 'data', 'client'],
        data() {
            return {
                privateMessage: '',
                comments: [],
            }
        },
        mounted() {
            this.getPrivateChats();

            try {
                window.Echo.private('client-between-nurse.' + this.nurse.id + '.' + this.client.id)
                    .listen('PrivateChat.ClientNurseSentMessage', (response) => {
                        let message = {
                            'user_name': response.result.user_name,
                            'message': response.result.message,
                            'client_sent': response.result.client_sent,
                            'nurse_sent': response.result.client_sent,
                            'created_at': response.result.created_at,
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
            getPrivateChats() {
                axios.get('bookings/get-private-chats/' + this.client.id)
                    .then((response) => {
                        console.log(response);
                        if (response.data.chat.length > 0) {
                            for (let value in response.data.chat) {
                                let message = {
                                    'user_name': response.data.chat[value].user_name,
                                    'message': response.data.chat[value].message,
                                    'client_sent': response.data.chat[value].client_sent,
                                    'nurse_sent': response.data.chat[value].client_sent,
                                    'created_at': response.data.chat[value].created_at,
                                };
                                this.comments.unshift(message);
                            }
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            sendPrivateMessage() {
                axios.post('/dashboard/nurse-private-chats', {
                    'client_id': this.client.id,
                    'nurse_id': this.nurse.id,
                    'privateMessage': this.privateMessage
                }).then((response) => {
                    if (response.data.success) {
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
        }
    }
</script>

<style scoped>
    .chat-wrapper {
        height: 250px;
        overflow: auto;
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
