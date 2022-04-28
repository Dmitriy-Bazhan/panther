<template>
    <div>
        <h5>FEEDBACK</h5>
        <div class="row">
            <div class="col-3">Feedback</div>
            <div class="col-9"><textarea v-model="feedback" cols="50">{{ feedback }}</textarea></div>
        </div>

        <div class="row">

            <div class="col-6" style="text-align: center;">
                <button class="btn btn-success btn-sm" v-on:click="saveFeedBack()">{{ $t('save') }}</button>
            </div>

            <div class="col-6" style="text-align: center;">
                <button class="btn btn-success btn-sm" v-on:click="closeModal()">{{ $t('close') }}</button>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "FeedBack",
        props: ['nurse'],
        data() {
            return {
                feedback: null,
            }
        },
        methods: {
            closeModal() {
                this.emitter.emit('close-modal');
            },
            saveFeedBack() {
                let data = {
                    'feedback': this.feedback,
                    'id': this.nurse.id,
                    'type': 'nurse'
                };
                console.log(data);
                axios.post('/feedback', {'data': data})
                    .then((response) => {
                        console.log(response.data);
                        if(response.data.success){
                            this.emitter.emit('close-modal');
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
