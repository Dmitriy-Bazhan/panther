<template>
    <div>
        <h5>{{ $t('complaint') }}</h5>

        <div class="row">
            <div class="col-3">{{ $t('complaint') }}</div>
            <div class="col-9"><textarea v-model="complaint" cols="50">{{ complaint }}</textarea></div>
        </div>

        <div class="row">

            <div class="col-6" style="text-align: center;">
                <button class="btn btn-success btn-sm" v-on:click="saveComplaint()">{{ $t('save') }}</button>
            </div>

            <div class="col-6" style="text-align: center;">
                <button class="btn btn-success btn-sm" v-on:click="closeModal()">{{ $t('close') }}</button>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Complaint",
        props: ['nurse'],
        data() {
            return {
                complaint: null,
            }
        },
        methods: {
            closeModal() {
                this.emitter.emit('close-modal');
            },
            saveComplaint() {
                axios.post('/complaint/set-client-complaint-on-nurse', {'complaint': this.complaint, 'nurse_id' : this.nurse.id})
                    .then((response) => {
                        if (response.data.success) {
                            this.closeModal();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
