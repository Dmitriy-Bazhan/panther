<template>
    <div class="pt-client" v-on:click="showChat()"
         v-bind:class="{'pt-client__active': index === $parent.nurse_id}">
        <div class="pt-client--avatar">
            <img :src="path + '/storage/' + nurse[0].entity.thumbnail_photo" alt="pic" v-if="nurse[0].entity.thumbnail_photo">
            <div class="pt-client--avatar-no-photo" v-else>
                <span>{{ nurse[0].first_name }}</span>
                <span>{{ nurse[0].last_name }}</span>
            </div>
            <span v-if="haveUnreadMessages" class="pt-client--signal"></span>
        </div>
        <div class="pt-client--info">
            <div class="pt-client--name">
                {{ nurse[0].first_name + ' ' + nurse[0].last_name}}
            </div>
            <div class="pt-client--msg" v-if="nurse.last_message">
                {{ nurse.last_message.message}}
            </div>
        </div>
        <div class="pt-client--meta" v-if="nurse.last_message">
            <div class="pt-client--date">
                {{formatDate(nurse.last_message.created_at)}}
            </div>
            <div class="pt-client--count" v-show="nurse.count > 0">
                {{nurse.count}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Nurse",
        props: ['index', 'nurse', 'firstChat'],
        data() {
            return {
                path: location.origin,
                active: false,
                haveUnreadMessages: false,
            }
        },
        mounted() {
            this.emitter.on('disable-show-alarm-new-message', e => {
                if(Number(this.nurse[0].id) === Number(e)){
                    this.nurse.count = 0
                }
            });

            if(this.firstChat === this.index){
                this.active = true;
            }

            this.emitter.on('active-nurse', e => {
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
            showChat() {
                this.emitter.emit('show-chat', this.index);
                this.emitter.emit('active-nurse', this.index);
            },
            sendToBookings() {
                window.open('/booking/' + this.index);
            },

            formatDate(date) {
                return dayjs(date).format('DD.MM.YY')
            },
        }
    }
</script>

<style scoped>
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
