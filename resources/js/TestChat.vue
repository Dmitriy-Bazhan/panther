<template>
    <div class="chat-main-block">
        <div class="container-fluid chat-header">
            <div class="row">
                <div class="col-10 ">
                    <p class="chat-header-text">Chat</p>
                </div>
            </div>
        </div>

        <div class="chat-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 vue-chat-content">
                        <div v-for="comment in comments">
                            <div class="chat-message-content-block">
                                <div class="chat-message-content-block">
                                    <span class="chat-message-content-block-text">{{ comment.message }}</span>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid chat-form">
                <div class="row">
                    <div class="col-12">
                        <form class="form">
                        <textarea id="vue-input_message" class="chat-input" rows="5" placeholder="Введите сообщение"
                                  name="chat_message"
                                  v-on:keypress="sendMessageClickEnter"
                        ></textarea>
                            <button class="chat-submit" v-on:click="sendMessageClick">
                                &#8657;
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TestChat",
    props: ['user'],
    data() {
        return {
            chatMessage: "chat-message",
            chatIncomingMessage: "chat-incoming-message",
            comments: [],
            token: $('meta[name=csrf-token]').attr('content'),
        }
    },
    mounted() {
        window.Echo.private('chat')
            .listen('TestChatMessage', (response) => {
                console.log(response);
                this.comments.unshift(response);
            }).error((error) => {
            console.log('ERROR IN SOCKETS CONNECT : ' + error);
        });
    },
    methods: {
        sendMessageClickEnter(e) {
            let key = e.which;
            if (key === 13) {
                this.sendMessage();
            }
        },
        sendMessageClick(event) {
            event.preventDefault();
            this.sendMessage()
        },
        sendMessage() {
            let message = $('#vue-input_message').val();
            let user_id = this.user.id;
            let username = this.user.first_name + ' ' + this.user.last_name;
            $('#vue-input_message').val('')
            axios.post(`/test/message`, {
                message: message,
                user_id: user_id,
                username: username,
            }).then((response) => {
                // this.comments.unshift({
                //     // 'created_at' : created_at,
                //     'message' : message,
                //     'user_id' : user_id,
                //     'username' : username
                // });
            }).catch((error) => {
                console.log(error);
            });
        },
    }
}
</script>

<style scoped>

</style>
