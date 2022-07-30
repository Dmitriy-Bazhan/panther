<template>
    <div class="pt-dashboard--header">
        <div class="pt-dashboard--header-left">
            <a href="/" class="pt-dashboard--header-logo">
                <img src="/images/logo.png" alt="logo">
            </a>
        </div>
        <div class="pt-dashboard--header-right">
            <h3 class="pt-dashboard--header-title">
                {{$route.meta.title}}
            </h3>
            <div class="pt-dashboard--header-block">
                <pt-dropdown icon="email" :href="msgUrl">
                    <template v-if="$store.state.messages && $store.state.messages > 0" v-slot:counter>
                        {{$store.state.messages}}
                    </template>
                </pt-dropdown>
            </div>
            <div class="pt-dashboard--header-block">
                <pt-dropdown icon="bell" @click="getNotice">
                    <template v-if="$store.state.notifications && $store.state.notifications > 0" v-slot:counter>
                        {{$store.state.notifications}}
                    </template>
                    <template v-slot:menu>
                        <div class="pt-dropdown--menu-item" v-for="(notification, index) in notifications">
                            <div class="pt-notification">
                                <div class="pt-notification--number">
                                    {{index + 1}}
                                </div>
                                <div class="pt-notification--body">
                                    <p class="pt-notification--date">
                                        {{notification.created_at}}
                                    </p>
                                    <p class="pt-notification--title">
                                        New {{notification.type}}
                                    </p>
                                </div>
                                <button class="pt-notification--close" @click="readNotice(notification.id)">
                                    <pt-icon type="cross"></pt-icon>
                                </button>
                            </div>
                        </div>
                    </template>
                </pt-dropdown>
            </div>
            <div class="pt-dashboard--header-block">
                <localization-component></localization-component>
            </div>
            <div class="pt-dashboard--header-block">
                <div class="pt-dashboard--header-block--inner">
                    <logout-component></logout-component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Localization from "./Localization";
import Logout from "./Logout";

export default {
    name: "Header",
    props: ['user', 'data', 'msgUrl'],
    components : {
        'localization-component' : Localization,
        'logout-component' : Logout,
    },
    data(){
        return {
            notifications: false
        }
    },
    mounted() {
        try {
            window.Echo.private('notifications.' + this.user.id)
                .listen('Notifications.NewNotificationEvent', (response) => {
                    console.log('This message for me.))');
                    this.$store.commit('setNotifications', response.unread_notifications_count)
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNECT : ' + error);
            });
        } catch {
            console.log('Websockets not work now');
        }
    },
    methods: {
        getNotice() {
            axios.get('/get-notification/' + this.user.id)
                .then((response) => {
                    if (response.data.data) {
                        console.log(response.data.data)
                        this.notifications = response.data.data
                    }
                }).catch((error) => {
                console.log(error)
            });
        },
        readNotice(id) {
            axios.post('/set-notification-status-read', {
                notification_id: id
            })
                .then((response) => {
                    if (response.data.data) {
                        console.log(response.data)
                    }
                }).catch((error) => {
                console.log(error)
            });
        },
    }
}
</script>

<style scoped>
.client-dashboard-header {
    padding: 5px;
    background: #9dc3fc;
}
</style>
