<template>
  <h3 class="pt-mb-10" v-if="error">Stripe payment error!</h3>
  <div v-else>
    <h3 class="pt-mb-10">Choose pay methods, cards</h3>

    <template v-if="loader">
      <pt-preloader></pt-preloader>
    </template>
    <template v-else>
      <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length === 0" class="">
        No payment method on file, please add a payment method.
      </div>

      <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length > 0">
        <div v-for="(method, key) in paymentMethods"
             :key="'method-'+key"
             @click="paymentMethodSelected = method.id"
             class="pt-payment--methods"
             :class="{'active': paymentMethodSelected === method.id }">
          <div class="pt-payment--methods-type">
            {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
          </div>
          <div class="pt-payment--methods-card">
            **** **** **** {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
          </div>
        </div>
      </div>

      <button class="pt-btn pt-sm pt-mt-15" @click="pay()">Pay</button>
    </template>
  </div>
</template>

<script>
export default {
  name: "PayPayment",
  props: ['payment'],
  data() {
    return {
      erro: false,
      loader: false,
      paymentMethods: [],
      paymentMethodsLoadStatus: 0,
      paymentMethodSelected: {}
    }
  },
  mounted() {
    this.loadPaymentMethods();
  },
  methods: {
    loadPaymentMethods() {
      this.loader = true
      this.paymentMethodsLoadStatus = 1;

      axios.get('/payment/payment-methods')
          .then(function (response) {
            this.paymentMethods = response.data;
            this.paymentMethodsLoadStatus = 2;
            this.loader = false
          }.bind(this));
    },
    pay() {
      this.loader = true
      axios.post('/payment/payment-pay', {
        'payment_id': this.payment.id,
        'payment_method_id': this.paymentMethodSelected
      })
          .then((response) => {
            if (response.data.success) {
              this.loader = false
              this.emitter.emit('temporary-pay');
            }
          })
          .catch((error) => {
            this.error = true
            console.log(error);
          });
    }
  }
}
</script>

<style scoped>

</style>
