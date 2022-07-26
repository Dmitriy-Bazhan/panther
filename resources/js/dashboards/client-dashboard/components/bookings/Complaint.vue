<template>
    <div>
      <h3 class="pt-title">
        {{ $t('complaint') }}
      </h3>
      <pt-textarea
          v-model="complaint"
          @update:modelValue="newValue => complaint = newValue"
      ></pt-textarea>

      <button class="pt-btn pt-lg pt-mt-20 pt-ml-a pt-mr-a" v-on:click="saveComplaint()">{{ $t('save') }}</button>
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
