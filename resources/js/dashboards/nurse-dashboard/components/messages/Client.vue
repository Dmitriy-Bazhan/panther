<template>
    <div class="pt-client" v-on:click="showChat()"
         v-bind:class="{'pt-client__active': index === $parent.client_id}">
        <div class="pt-client--avatar">
            <img :src="path + '/storage/' + client[0].entity.thumbnail_photo" alt="pic" v-if="client[0].entity.thumbnail_photo">
            <div class="pt-client--avatar-no-photo" v-else>
                <span>{{ client[0].first_name }}</span>
                <span>{{ client[0].last_name }}</span>
            </div>
            <span v-if="haveUnreadMessages" class="pt-client--signal"></span>
        </div>
        <div class="pt-client--info">
            <div class="pt-client--name">
                {{ client[0].first_name + ' ' + client[0].last_name}}
            </div>
            <div class="pt-client--msg" v-if="client.last_message">
                {{ client.last_message.message}}
            </div>
        </div>
        <div class="pt-client--meta" v-if="client.last_message">
            <div class="pt-client--date">
                {{formatDate(client.last_message.created_at)}}
            </div>
            <div class="pt-client--count" v-show="client.count > 0">
                {{client.count}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Client",
        props: ['index', 'client', 'firstChat'],
        data() {
            return {
                path: location.origin,
                active: false,
                haveUnreadMessages: false,
            }
        },
        mounted() {
            this.emitter.on('disable-show-alarm-new-message', e => {
                if(Number(this.client[0].id) === Number(e)){
                    this.client.count = 0
                }
            });

            if(this.firstChat === this.index){
                this.active = true;
            }

            this.emitter.on('active-client', e => {
                if(e === this.index){
                    this.active = true;
                }else {
                    this.active = false;
                }
            });

            this.emitter.on('disable-alert-on-nurse-name', e => {
                if (e === this.index) {
                    this.haveUnreadMessages = false;
                }
            });

            this.emitter.on('chat-have-unread-message', e => {
                if (e == this.index) {
                    this.haveUnreadMessages = true;
                }
            });
        },
        methods: {
            formatDate(date) {
                return dayjs(date).format('DD.MM.YY')
            },
            showChat() {
                this.emitter.emit('show-chat', this.index);
                this.emitter.emit('active-client', this.index);
            },
        }
    }
</script>

<style scoped>
</style>
