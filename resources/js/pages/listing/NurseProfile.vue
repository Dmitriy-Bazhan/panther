<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <h4>Nurse profile</h4>
            </div>
            <div class="col-1 offset-7">
                <button class="btn btn-success btn-sm" v-on:click="closeModalNurseProfile()">close</button>
            </div>
        </div>

        <div v-if="nurse !== null" class="row">
            <div class="col-7">
                <div>
                    <div class="nurse-profile-item">{{ $t('name') }}: {{ nurse.first_name }}</div>
                    <div class="nurse-profile-item">{{ $t('last_name') }}: {{ nurse.last_name }}</div>
                    <div class="nurse-profile-item">{{ $t('age') }}: {{ nurse.entity.age }}</div>
                    <div class="nurse-profile-item">{{ $t('gender') }}: {{ nurse.entity.gender }}</div>
                    <div class="nurse-profile-item">{{ $t('experience') }}: {{ nurse.entity.experience }}</div>
                    <div class="nurse-profile-item">{{ $t('price') }}: {{ nurse.entity.price.hourly_payment }}</div>
                    <div class="nurse-profile-item">{{ $t('distance') }}: distance</div>

                    <div class="nurse-profile-item">{{ $t('provide_supports') }}:</div>
                    <div class="nurse-profile-item" v-for="support in nurse.entity.provide_supports">
                        . {{ $t(support.name) }}
                    </div>

                    <div class="nurse-profile-item">{{ $t('additional_info') }} :</div>
                    <div class="nurse-profile-item" v-for="additional_info in nurse.entity.additional_info">
                        . {{ filterAdditionalInfo(additional_info.id) }}
                    </div>

                </div>
            </div>

            <div class="col-5 nurse-profile-image-wrapper">
                <img v-bind:src="path + '/storage/' + nurse.entity.original_photo" alt="no-photo"
                     class="nurse-profile-image">
            </div>

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
                        <button class="btn btn-success btn-sm" v-on:click="sendPrivateMessage()">{{ $t('send') }}
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-dark btn-sm" v-on:click="sendToBookings">{{ $t('send_to_bookings') }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
</template>

<script>
    import SingleChat from "../../dashboards/nurse-dashboard/components/bookings/SingleChat";

    export default {
        name: "NurseProfile",
        props: ['nurse', 'data', 'user'],
        components: {
            single_chat: SingleChat,
        },
        data() {
            return {
                path: location.origin,
                privateMessage: '',
                comments: [],
            }
        },
        mounted() {
            this.getPrivateChats();

            try {
                window.Echo.private('client-between-nurse.' + this.nurse.id + '.' + this.user.id)
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
            sendToBookings() {
                window.open('booking/' + this.nurse.id);
            }, getPrivateChats() {
                axios.get('/listing/get-private-chats/' + this.nurse.id)
                    .then((response) => {
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
                axios.post('listing/send-private-message', {
                    'nurse_id': this.nurse.id,
                    'privateMessage': this.privateMessage
                }).then((response) => {
                    this.privateMessage = '';
                }).catch((error) => {
                    console.log(error);
                });
            },
            filterAdditionalInfo(id) {
                let info = this.data.additional_info.filter(function (el) {
                    if (el.id === id) {
                        return true;
                    }
                });

                return info[0].data.data;
            },
            closeModalNurseProfile() {
                this.emitter.emit('close-modal-nurse-profile');
            },
            formatDate(date) {
                let a = String(date).split('T');
                return a[0] + ' ' + String(a[1].split('.')[0]);
            },
        },
    }
</script>

<style scoped>
    .nurse-profile-image-wrapper {
        padding: 10px;
        height: 180px;
    }

    .nurse-profile-image {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }

    .nurse-profile-item {
        font-size: 14px;
        font-weight: 600;
    }

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
