<template>
    <div class="show-chats-wrapper">
        <h1>CHATS</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-sm btn-success" v-on:click="closeModal()">{{ $t('close') }}</button>
            </div>
        </div>

        <div v-if="chats" class="row">
            <div class="col-4">
                <template v-for="(chat, index) in chats">
                    <div v-on:click="showChat(index)"
                         v-bind:class="[active == index ? 'nurse-chat-wrapper-active container-fluid' : 'nurse-chat-wrapper container-fluid']">
                        <span
                            class="nurse-name">{{ clients[index][0].first_name + ' ' + clients[index][0].last_name}}</span>
                    </div>
                </template>
            </div>

            <div class="col-7 chat-wrapper">
                <template v-for="(chat, index) in chats">
                    <div v-if="chat.length > 0 && chat_active == index" v-for="comment in chat">
                        <div v-if="comment.client_sent === 'yes'" class="chat-nurse-message-wrapper">
                        <span class="chat-nurse-name">
                            {{ comment.user_name }}
                        </span>
                            <br>
                            <span class="chat-nurse-message">
                            <span :style="{ 'color' : comment.status === 'removed' ? 'gray' : '' }">{{ comment.message }}</span>
                        </span>
                            <br>
                            <span class="chat-nurse-date">
                            {{ formatDate(comment.created_at) }}
                        </span>
                            <span v-if="comment.status != 'removed'" class="ti-trash"
                                  v-on:click="removeComment(comment)"></span>
                        </div>

                        <div v-else class="nurse-client-message-wrapper">
                        <span class="nurse-client-name">
                            {{ comment.user_name }}
                        </span>
                            <br>
                            <span class="nurse-client-message">
                            <span
                                :style="{ 'color' : comment.status =='removed' ? 'gray' : '' }">{{ comment.message }}</span>
                        </span>
                            <br>
                            <span class="nurse-client-date">
                            {{ formatDate(comment.created_at) }}
                        </span>
                            <span v-if="comment.status != 'removed'" class="ti-trash"
                                  v-on:click="removeComment(comment)"></span>
                        </div>
                    </div>
                </template>
            </div>

        </div>
        <br>
        <div class="row" v-if="chats">
            <div class="col-4" v-if="client">
                <button class="btn btn-sm btn-success" v-if="client.banned == 'no'" v-on:click="banClient()">
                    {{ $t('ban_client') + ': ' + client.full_name}}
                </button>
                <button class="btn btn-sm btn-success" v-if="client.banned == 'yes'" v-on:click="dismissBanClient()">
                    {{ $t('dismiss_ban_client') + ': ' + client.full_name}}
                </button>
            </div>
            <div class="col-4 offset-4">
                <button class="btn btn-sm btn-success" v-if="nurse.banned == 'no'" v-on:click="banNurse()">
                    {{ $t('ban_nurse') + ': ' + nurse.full_name}}
                </button>
                <button class="btn btn-sm btn-success" v-if="nurse.banned == 'yes'" v-on:click="dismissBanNurse()">
                    {{ $t('dismiss_ban_nurse') + ': ' + nurse.full_name}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ShowChats",
        props: ['nurse', 'data'],
        data() {
            return {
                chats: false,
                clients: [],
                active: false,
                client: false,
                chat_active: false,
            }
        },
        mounted() {
            this.getPrivateChats();
        },
        methods: {
            removeComment(comment) {
                axios.get('admin-remove-message/' + comment.id)
                    .then((response) => {
                        if (response.data.success) {
                            comment.message = 'Message is deleted admin';
                            comment.status = 'removed';
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            closeModal() {
                this.emitter.emit('close-modal');
            },
            getPrivateChats() {
                axios.get('get-nurse-chats/' + this.nurse.id)
                    .then((response) => {
                        this.chats = response.data.chats;
                        this.clients = response.data.clients;
                        this.active = Object.keys(this.chats)[0];
                        this.chat_active = Object.keys(this.chats)[0];
                        if(this.active !== undefined){
                            this.client = this.clients[this.active][0];
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            showChat(index) {
                this.chat_active = index;
                this.active = index;
                this.client = this.client[index][0];
            },
            formatDate(date) {
                let a = String(date).split('T');
                return a[0] + ' ' + String(a[1].split('.')[0]);
            },
            banNurse() {
                axios.get('ban-user/' + this.nurse.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.nurse.banned = 'yes';
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            dismissBanNurse() {
                axios.get('dismiss-ban-user/' + this.nurse.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.nurse.banned = 'no';
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            banClient() {
                axios.get('ban-user/' + this.client.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.client.banned = 'yes';
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            dismissBanClient() {
                axios.get('dismiss-ban-user/' + this.client.id)
                    .then((response) => {
                        if (response.data.success) {
                            this.client.banned = 'no';
                            this.emitter.emit('response-success-true');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
    }
</script>

<style scoped>
    .ti-trash:hover {
        color: red;
    }

    .show-chats-wrapper {
        position: fixed;
        top: 10%;
        left: 10%;
        width: 80%;
        height: 600px;
        border: solid 1px black;
        border-radius: 10px;
        background-color: #0a58ca;
    }

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

    .nurse-chat-wrapper {
        background: #78886c;
        padding: 10px;
        border: solid 1px white;
        cursor: pointer;
    }

    .nurse-chat-wrapper:hover {
        background: #abbf9b;
    }

    .nurse-name {
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .nurse-chat-wrapper-active {
        background: #36e64e;
        padding: 10px;
        border: solid 1px #14991b;
    }
</style>
