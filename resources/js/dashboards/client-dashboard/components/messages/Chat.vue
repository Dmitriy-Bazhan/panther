<template>
    <div class="pt-chat--head" v-if="nurses[nurse_id]">
        <div class="pt-chat--head-avatar">
            <img :src="path + '/storage/' + nurses[nurse_id][0].entity.thumbnail_photo" alt="pic" v-if="nurses[nurse_id][0].entity.thumbnail_photo">
            <div class="pt-chat--head-avatar-no-photo" v-else>
                <span>{{ nurses[nurse_id][0].first_name }}</span>
                <span>{{ nurses[nurse_id][0].last_name }}</span>
            </div>
        </div>

        <div class="pt-chat--head-name">
            {{nurses[nurse_id][0].full_name}}
        </div>
        <button class="pt-link" @click.prevent="deleteChat" v-if="nurses[nurse_id].chat.status === 'active'">
            Delete Chat
        </button>
        <button class="pt-link" @click.prevent="activateChat" v-else>
            Activate Chat
        </button>
    </div>

    <div class="pt-chat">
        <template v-if="commentsClone.length > 0" v-for="comment in commentsClone">
            <div v-if="comment.client_sent === 'yes'" class="pt-chat--message pt-chat--message__inner" :class="{'pt-chat--group': comment.tmpDate}">
                <div class="pt-chat--message-avatar--wrapper">
                    <div class="pt-chat--message-avatar" v-if="comment.tmpDate">
                        <img :src="path + '/storage/' + nurses[nurse_id][0].entity.thumbnail_photo" alt="pic" v-if="nurses[nurse_id][0].entity.thumbnail_photo">
                        <div class="pt-chat--message-avatar--no-photo" v-else>
                            <span>{{ nurses[nurse_id][0].first_name }}</span>
                            <span>{{ nurses[nurse_id][0].last_name }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-chat--message-block">
                    <div class="pt-chat--message-date" v-if="comment.tmpDate">
                        {{ comment.tmpDate }}
                    </div>
                    <div class="pt-chat--message-body">
                        {{ comment.message }}
                    </div>
                </div>
            </div>

            <div v-else class="pt-chat--message pt-chat--message__outer" :class="{'pt-chat--group': comment.tmpDate}">
                <div class="pt-chat--message-block">
                    <div class="pt-chat--message-date" v-if="comment.tmpDate">
                        {{ comment.tmpDate }}
                    </div>
                    <div class="pt-chat--message-body">
                        {{ comment.message }}

                        <template v-if="comment.have_file === 'yes'">
                            <img :src="path + '/storage/' + comment.thumbnail_file" alt="">
                        </template>
                    </div>
                </div>
                <div class="pt-chat--message-avatar--wrapper">
                    <div class="pt-chat--message-avatar" v-if="comment.tmpDate">
                        <img :src="path + '/storage/' + user.entity.thumbnail_photo" alt="pic" v-if="user.entity.thumbnail_photo">
                        <div class="pt-chat--message-avatar--no-photo" v-else>
                            <span>{{ user.first_name }}</span>
                            <span>{{ user.last_name }}</span>
                        </div>


                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="row" v-if="showMarkIsReadBlock" v-show="false">
        <div class="col-4">
            {{ $t('chat_have_unread_messages') }}
        </div>
        <div class="col-2">
            <button class="btn btn-success btn-sm" v-on:click="markAsReadThisChat()">{{ $t('mark_as_read') }}</button>
        </div>
    </div>


    <form action="" @submit.prevent="sendPrivateMessage()" class="pt-chat--ctrl">
        <label class="pt-chat--ctrl-attach">
            <input type="file" @change="getPreview" ref="file">
            <template v-if="filePreview">
                <img :src="filePreview" alt="pic">
                <button class="pt-chat--ctrl-attach--remove" @click.prevent="removePreview">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </template>
            <pt-icon v-else type="attach"></pt-icon>
        </label>
        <div class="pt-chat--ctrl-input">
            <input type="text" v-model="privateMessage">
            <button class="pt-btn">
                {{ $t('send') }}
            </button>
        </div>
    </form>
</template>

<script>
    export default {
        name: "Chat",
        props: ['user', 'nurses', 'chat'],
        data() {
            return {
                path: location.origin,
                filePreview: '',
                privateMessage: '',
                showMarkIsReadBlock: false,
                comments: [],
                commentsClone: [],
                nurse_id: null,
                haveNewMessages: null
            }
        },
        mounted() {
            this.emitter.on('get-message', e => {
                this.nurse_id = e.nurse_id;
                this.haveNewMessages = e.haveNewMessages;
                this.showMarkIsReadBlock = false;
                this.checkChatsHaveUnreadMessages();
                this.getComments();
                this.listenBroadcast();
                this.markAsReadThisChat();
            });

            this.emitter.on('chat-have-unread-message', e => {
                if (e == this.nurse_id) {
                    this.showMarkIsReadBlock = true;
                }
            });
        },
        watch: {
            comments: {
                handler(newValue, oldValue) {
                    let self = this;
                    let tmpDate
                    let isInner
                    let deep = _.cloneDeep(self.comments);

                    deep.reverse().forEach(function (item){
                        if(tmpDate){
                            if(dayjs(tmpDate).isSame(item.created_at, 'day')){
                                if(isInner === item.client_sent && dayjs(item.created_at).format('HH:mm') === dayjs(tmpDate).format('HH:mm')){
                                    item.tmpDate = false
                                }
                                else{
                                    if(dayjs().isSame(item.created_at, 'day')){
                                        item.tmpDate = dayjs(item.created_at).format('HH:mm')
                                    }
                                    else{
                                        item.tmpDate = dayjs(item.created_at).format('DD.MM.YY - HH:mm')
                                    }
                                }
                                tmpDate = item.created_at
                            }
                            else{
                                tmpDate = item.created_at
                                if(dayjs().isSame(item.created_at, 'day')){
                                    item.tmpDate = dayjs(item.created_at).format('HH:mm')
                                }
                                else{
                                    item.tmpDate = dayjs(item.created_at).format('DD.MM.YY - HH:mm')
                                }
                            }
                        }
                        else{
                            tmpDate = item.created_at
                            if(dayjs().isSame(item.created_at, 'day')){
                                item.tmpDate = dayjs(item.created_at).format('HH:mm')
                            }
                            else{
                                item.tmpDate = dayjs(item.created_at).format('DD.MM.YY - HH:mm')
                            }
                        }
                        isInner = item.client_sent
                    })

                    self.commentsClone = deep.reverse()
                },
                deep: true
            }
        },
        methods: {
            markAsReadThisChat(){
                let self = this
                axios.post('/dashboard/client-private-chats/mark-as-read', {
                    'client_id' :this.user.id,
                    'nurse_id': this.nurse_id,
                }).then((response) => {
                    if(response.data.success === true){
                        this.showMarkIsReadBlock = false;
                        this.emitter.emit('disable-alert-on-nurse-name', this.nurse_id);
                        if(response.data.have_new_message === 'yes'){
                            this.emitter.emit('disable-show-alarm-new-message', this.nurse_id);
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
                message.append('client_id',this.user.id,);
                message.append('nurse_id', this.nurse_id,);
                message.append('privateMessage', this.privateMessage,);

                axios.post('/dashboard/client-private-chats', message ,{
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }).then((response) => {
                    if (response.data.success) {
                        this.privateMessage = '';
                        this.$refs.file.value = null;
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
                    if(this.haveNewMessages[el] == this.nurse_id){
                        this.emitter.emit('chat-have-unread-message', this.nurse_id);
                        this.showMarkIsReadBlock = true;
                    }
                }
            },
            deleteChat(){
                let self = this
                axios.post( '/set-chat-on-delete-status', {
                    'chat_id': this.chat.id,
                })
                    .then((response) => {
                        if(response.data.success){
                            self.nurses[self.nurse_id].chat.status = 'deleted'
                            self.emitter.emit('change-message-status', 'deleted');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            activateChat(){
                let self = this
                axios.post( '/set-chat-on-active-status', {
                    'chat_id': this.chat.id,
                })
                    .then((response) => {
                        if(response.data.success){
                            self.nurses[self.nurse_id].chat.status = 'active'
                            self.emitter.emit('change-message-status', 'active');
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
            removePreview(e){
                let self = this
                self.$refs.file.value = ''
                self.filePreview = ''
            },
            getPreview(e){
                let self = this
                let reader = new FileReader();

                reader.readAsDataURL(e.target.files[0]);

                reader.onload = function () {
                    self.filePreview = reader.result
                };
            },
            listenBroadcast(){
                let self = this
                try {
                    window.Echo.private('client-between-nurse.' + this.nurse_id + '.' + this.user.id)
                        .listen('PrivateChat.ClientNurseSentMessage', (response) => {
                            if(Number(response.result.nurse_user_id) === Number(self.nurse_id)){
                                let message = {
                                    'user_name': response.result.user_name,
                                    'message': response.result.message,
                                    'client_sent': response.result.client_sent,
                                    'nurse_sent': response.result.client_sent,
                                    'created_at': response.result.created_at,
                                    'have_file': response.result.have_file,
                                    'original_file': response.result.original_file,
                                    'thumbnail_file': response.result.thumbnail_file,
                                };
                                this.comments.unshift(message);
                            }
                        }).error((error) => {
                        console.log('ERROR IN SOCKETS CONNTECT : ' + error);
                    });
                } catch (e) {
                    console.log('Websockets not work');
                }
            },
            getComments(){
                axios.get('/dashboard/client-private-chats/get-current-chat/'+ this.user.id + '/' + this.nurse_id)
                    .then((response) => {
                        if(response.data.success){
                            this.comments = response.data.messages;
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

</style>
