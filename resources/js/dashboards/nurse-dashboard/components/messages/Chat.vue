<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                Chat:
            </div>
            <div class="col-10 chat-wrapper">
                <p v-if="comments.length > 0" v-for="comment in comments">
                    {{ comment.user_name + ': ' + comment.message  + ' data: ' + comment.created_at}}
                </p>
            </div>

        </div>

        <div class="row">
            <div class="col-2">
                Message:
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" v-model="privateMessage">
            </div>
            <div class="col-2">
                <button class="btn btn-success btn-sm" v-on:click="sendPrivateMessage()">send</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Chat",
        props: ['user', 'index', 'chat'],
        data() {
            return {
                comments: [],
                privateMessage: '',
            }
        },
        mounted() {
            if (this.chat.length > 0) {
                for (let value in this.chat) {

                    let message = {
                        'user_name': this.chat[value].user_name,
                        'message': this.chat[value].message,
                        'client_sent' : this.chat[value].client_sent,
                        'nurse_sent' : this.chat[value].client_sent,
                        'created_at' : this.chat[value].created_at,
                    };

                    this.comments.unshift(message);
                }
                ;
            }

            window.Echo.private('client-between-nurse.' + this.user.id + '.' + this.index)
                .listen('PrivateChat.ClientSentMessage', (response) => {
                    console.log('RESPONSE');
                    console.log(response);

                    let message = {
                        'user_name': response.user_name,
                        'message': response.privateMessage,
                        'client_sent' : response.client_sent,
                        'nurse_sent' : response.client_sent,
                        'created_at' : response.created_at,
                    };

                    this.comments.unshift(message);
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        },
        methods: {
            sendPrivateMessage() {
                console.log(this.privateMessage);
            },
        }
    }
</script>

<style scoped>

</style>
