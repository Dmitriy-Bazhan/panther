<template>
    <div class="send-message-wrapper">
        <h5>{{ $t('send_message') }}</h5>

        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-sm btn-success" v-on:click="closeSendMessage()">{{ $t('close') }}</button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-10 offset-1">
                <textarea class="form-control form-control-sm" v-model="message"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-2 offset-10">
                <button class="btn btn-sm btn-success" v-on:click="sendMessageToUser()">{{ $t('send') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SendMessage",
        props: ['temp_user'],
        data() {
            return {
                message: null,
            }
        },
        methods: {
            closeSendMessage() {
                this.emitter.emit('close-modal');
            },
            sendMessageToUser() {
                axios.post('send-message-admin-to-user', {'user_id': this.temp_user.id, 'message': this.message })
                    .then((response) => {
                        if (response.data.success) {
                            this.emitter.emit('close-modal');
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
    .send-message-wrapper {
        position: fixed;
        top: 10%;
        left: 20%;
        width: 60%;
        height: 250px;
        border: solid 1px black;
        border-radius: 10px;
        background-color: #0b5ed7;
    }
</style>
