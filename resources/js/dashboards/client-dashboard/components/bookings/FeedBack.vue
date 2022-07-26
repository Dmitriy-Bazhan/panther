<template>
  <div>
    <h3 class="pt-title">
      FEEDBACK
    </h3>
    <pt-textarea
        v-model="feedback"
        @update:modelValue="newValue => feedback = newValue"
    ></pt-textarea>

    <button class="pt-btn pt-lg pt-mt-20 pt-ml-a pt-mr-a" v-on:click="saveFeedBack()">{{ $t('save') }}</button>
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
      axios.post('/feedback', {'data': data})
          .then((response) => {
            if (response.data.success) {
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
