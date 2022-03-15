<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                Chat:
            </div>
            <div class="col-10 chat-wrapper">
                  <p v-if="comments.length > 0" v-for="comment in comments">{{ comment }}</p>
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
        props: ['user'],
        data() {
            return {
                comments: [],
                privateMessage : '',
            }
        },
        mounted() {
            window.Echo.private('client-between-nurse.' + this.user.id + '.' + '2')
                .listen('PrivateChat.ClientSentMessage', (response) => {
                    console.log('RESPONSE');
                    console.log(response);
                    this.comments.unshift(response.privateMessage);
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        },
        methods : {
            sendPrivateMessage(){
                console.log(this.privateMessage);
            },
        }
    }
</script>

<style scoped>

</style>
