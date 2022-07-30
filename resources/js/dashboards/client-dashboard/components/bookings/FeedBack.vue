<template>
  <div>
    <h3 class="pt-heading">
        Bewertung schreiben
    </h3>

      <div class="pt-finder--form-block">
          <div class="pt-finder--form-label">
              Bewertung:
          </div>
          <pt-rate
              v-model="rate"
              @update:modelValue="newValue => rate = newValue">

          </pt-rate>
      </div>

      <div class="pt-finder--form-block">
          <div class="pt-finder--form-label">
              Ihre Meinung:
          </div>
          <pt-textarea
              v-model="feedback"
              @update:modelValue="newValue => feedback = newValue"
          ></pt-textarea>
      </div>


    <button class="pt-btn pt-lg pt-mt-20 pt-ml-a pt-mr-a" v-on:click="saveFeedBack()">{{ $t('send') }}</button>
  </div>
</template>

<script>
export default {
  name: "FeedBack",
  props: ['nurse'],
  data() {
    return {
      feedback: null,
      rate: null,
    }
  },
  methods: {
    closeModal() {
      this.emitter.emit('close-modal');
    },
    saveFeedBack() {
      let data = {
        'feedback': this.feedback,
        'rate': this.rate,
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
