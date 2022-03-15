<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <h4>Nurse profile</h4>
            </div>
            <div class="col-1 offset-7">
                <button class="btn btn-success btn-sm" v-on:click="closeModalNurseProfile()">close</button>
            </div>
        </div>

        <div v-if="nurse !== null" class="row">
            <div class="col-7">
                <div>
                    <div class="nurse-profile-item">name: {{ nurse.first_name }}</div>
                    <div class="nurse-profile-item">last_name: {{ nurse.last_name }}</div>
                    <div class="nurse-profile-item">age: {{ nurse.entity.age }}</div>
                    <div class="nurse-profile-item">gender: {{ nurse.entity.gender }}</div>
                    <div class="nurse-profile-item">experience: {{ nurse.entity.experience }}</div>
                    <div class="nurse-profile-item">price: {{ nurse.entity.price.hourly_payment }}</div>
                    <div class="nurse-profile-item">distance: distance</div>

                    <div class="nurse-profile-item">provide_supports :</div>
                    <div class="nurse-profile-item" v-for="support in nurse.entity.provide_supports">
                        . {{ $t(support.name) }}
                    </div>

                    <div class="nurse-profile-item">additional_info :</div>
                    <div class="nurse-profile-item" v-for="additional_info in nurse.entity.additional_info">
                        . {{ filterAdditionalInfo(additional_info.id) }}
                    </div>

                </div>
            </div>

            <div class="col-5 nurse-profile-image-wrapper">
                <img v-bind:src="path + '/storage/' + nurse.entity.original_photo" alt="no-photo"
                     class="nurse-profile-image">
            </div>

            <div class="row">
                <div class="col-2">
                    Chat:
                </div>
                <div class="col-10 chat-wrapper">

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
    </div>
</template>

<script>
    export default {
        name: "NurseProfile",
        props: ['nurse', 'data', 'user'],
        data() {
            return {
                path: location.origin,
                privateMessage: '',
            }
        },
        mounted() {
            window.Echo.private('client-between-nurse.' + this.nurse.id + '.' + this.user.id)
                .listen('PrivateChat.ClientSentMessage', (response) => {
                    console.log('RESPONSE');
                    console.log(response);
                    // this.comments.unshift(response);
                }).error((error) => {
                console.log('ERROR IN SOCKETS CONNTECT : ' + error);
            });
        },
        methods: {
            sendPrivateMessage() {
                axios.post('listing/send-private-message', {
                    'nurse_id': this.nurse.id,
                    'privateMessage': this.privateMessage
                }).then((response) => {
                    console.log(response);
                }).catch((error) => {
                        console.log(error);
                    });
            },
            filterAdditionalInfo(id) {
                let info = this.data.additional_info.filter(function (el) {
                    if (el.id === id) {
                        return true;
                    }
                });

                return info[0].data.data;
            },
            closeModalNurseProfile() {
                this.emitter.emit('close-modal-nurse-profile');
            },
        },
    }
</script>

<style scoped>
    .nurse-profile-image-wrapper {
        padding: 10px;
        height: 180px;
    }

    .nurse-profile-image {
        width: 90%;
        height: 90%;
        object-fit: contain;
    }

    .nurse-profile-item {
        font-size: 14px;
        font-weight: 600;
    }
</style>
