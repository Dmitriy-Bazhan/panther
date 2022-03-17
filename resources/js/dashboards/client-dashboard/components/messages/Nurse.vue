<template>
    <div v-on:click="showChat()"
         v-bind:class="[active ? 'nurse-chat-wrapper-active container-fluid' : 'nurse-chat-wrapper container-fluid']">
        <span class="nurse-name">{{ nurse[0].first_name + ' ' + nurse[0].last_name}}</span>
        &nbsp;<span v-if="haveUnreadMessages" class="alarm-signal blink"></span>
    </div>
</template>

<script>
    export default {
        name: "Nurse",
        props: ['index', 'nurse', 'firstChat'],
        data() {
            return {
                active: false,
                haveUnreadMessages: false,
            }
        },
        mounted() {
            if (this.firstChat === this.index) {
                this.active = true;
            }
            this.emitter.on('active-nurse', e => {
                if (e === this.index) {
                    this.active = true;
                } else {
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
