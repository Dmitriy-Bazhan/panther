<template>
    <div class="container-fluid">

        <div class="row">
            <div v-if="not_filled_info" class="col-2">
                <span class="alarm-signal blink"></span>&nbsp;<span class="alarm">You must filled info</span>
            </div>
            <div v-if="photo_not_exists" class="col-2">
                <span class="alarm-signal blink"></span>&nbsp;<span class="alarm">Photo not exists</span>
            </div>
            <div v-if="profile_not_approved" class="col-3">
                <span class="alarm-signal blink"></span>&nbsp;<span class="alarm">Your profile is not aprroved. Wait, please</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Notification",
    props: ['user'],
    data() {
       return {
           not_filled_info : true,
           profile_not_approved: true,
           photo_not_exists: true,
       }
    },
    mounted() {
        if(this.user.entity.is_approved === 'yes'){
            this.profile_not_approved = false;
        }

        if(this.user.entity.info_is_full === 'yes'){
            this.not_filled_info = false;
        }

        if(this.user.entity.info_is_full === 'no' && this.user.entity.change_info === 'yes'){
            this.not_filled_info = false;
        }

        if(this.user.entity.original_photo !== null){
            this.photo_not_exists = false;
        }

        this.emitter.on('user-finished-fill-info', e => {
            this.not_filled_info = false;
        });

        this.emitter.on('photo-exist', e => {
            this.photo_not_exists = false;
        });
    }
}
</script>

<style scoped>

</style>
