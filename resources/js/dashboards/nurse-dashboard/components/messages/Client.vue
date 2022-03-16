<template>
    <div v-on:click="showChat()"
         v-bind:class="[active ? 'client-chat-wrapper-active container-fluid' : 'client-chat-wrapper container-fluid']">
        <span class="client-name">{{ client[0].first_name + ' ' + client[0].last_name}}</span>
    </div>
</template>

<script>
    export default {
        name: "Client",
        props: ['index', 'client', 'firstChat'],
        data() {
            return {
                active: false,
            }
        },
        mounted() {
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
        },
        methods: {
            showChat() {
                this.emitter.emit('show-chat', this.index);
                this.emitter.emit('active-client', this.index);
            },
        }
    }
</script>

<style scoped>
    .client-chat-wrapper {
        background: #78886c;
        padding: 10px;
        border: solid 1px white;
        cursor: pointer;
    }

    .client-chat-wrapper:hover {
        background: #abbf9b;
    }

    .client-name {
        font-size: 14px;
        font-weight: 600;
        color: white;
    }

    .client-chat-wrapper-active {
        background: #36e64e;
        padding: 10px;
        border: solid 1px #14991b;
    }
</style>
