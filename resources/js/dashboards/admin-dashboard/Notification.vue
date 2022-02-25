<template>
    <div class="container-fluid">
        <div class="row">
            <div v-if="incoming_new_user_info" class="col-2">
                <span class="alarm-signal blink"></span>&nbsp;<span class="alarm">Incoming new user info</span>
            </div>
<!--            <div v-if="profile_not_approved" class="col-3">-->
<!--                <span class="alarm-signal blink"></span>&nbsp;<span class="alarm">Your profile is not aprroved. Wait, please</span>-->
<!--            </div>-->
        </div>
    </div>

</template>

<script>
export default {
    name: "Notification",
    props: ['user', 'data'],
    data() {
        return {
            incoming_new_user_info: false,
        }
    },
    mounted() {
        if(this.data.incoming_new_user_info){
            this.incoming_new_user_info = true;
        }

        try{
        window.Echo.private('admin')
            .listen('Admin.NurseAddNewProfile', (response) => {
                this.incoming_new_user_info = true;
            }).error((error) => {
            console.log('ERROR IN SOCKETS CONNECT : ' + error);
        });
        }catch {
            console.log('Websockets not work now');
        }
    }
}
</script>

<style scoped>

</style>
