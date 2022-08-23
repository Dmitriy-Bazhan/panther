<template>
  <template v-if="error">
    <h2>Error to load stripe data (reload page)</h2>
  </template>
  <template v-else>
    <pt-preloader v-show="!stripe"></pt-preloader>

    <div class="pt-finder--form-block" v-show="!!stripe">

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          Card Holder Name
        </p>
        <pt-input type="text" :modelValue="name"
                  icon="user"
                  @update:modelValue="newValue => name = newValue"
        ></pt-input>
      </div>

      <div class="pt-finder--form-group">
        <p class="pt-form--label">
          Card
        </p>
        <div id="card-element">

        </div>
      </div>

      <div class="pt-finder--form-group">
        <button class="pt-btn pt-lg" @click="submitPaymentMethod()">
          Save Payment Method
        </button>
      </div>
      <template v-if="loader">
        <pt-preloader></pt-preloader>
      </template>
      <template v-if="!loader">
        <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length === 0" class="">
          No payment method on file, please add a payment method.
        </div>

        <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length > 0">
          <h6 class="pt-mb-10 pt-mt-10">
            OR
          </h6>
          <div v-for="(method, key) in paymentMethods"
               :key="'method-'+key"
               @click="selectPaymentMethod(method.id)"
               class="pt-payment--methods"
               :class="{'active': paymentMethodSelected === method.id }">
            <div class="pt-payment--methods-type">
              {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
            </div>
            <div class="pt-payment--methods-card">
              **** **** **** {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
            </div>
            <div class="pt-payment--methods-ctrl">
              <button class="pt-btn--round" v-on:click.stop="removePaymentMethod( method.id )">
                <pt-icon type="cross"></pt-icon>
              </button>
            </div>
          </div>
        </div>
      </template>
    </div>
  </template>
</template>

<script>
export default {
  name: "AddCard",
  props: ['user', 'data'],
  data() {
    return {
      error: false,
      loader: false,
      name: '',
      stripeAPIToken: '',
      intentToken: '',
      stripe: '',
      elements: '',
      card: '',
      addPaymentStatus: 0,
      addPaymentStatusError: '',
      paymentMethods: [],
      paymentMethodsLoadStatus: 0,
      paymentMethodSelected: {}
    }
  },
  mounted() {
    this.getStripeAPIToken();
    this.loadPaymentMethods();
  },
  methods: {
    selectPaymentMethod(id) {
      if(this.paymentMethodSelected === id){
        this.paymentMethodSelected = {}
      }
      else{
        this.paymentMethodSelected = id
      }
    },
    submitPaymentMethod() {
      this.loader = true;
      this.addPaymentStatus = 1;

      this.stripe.confirmCardSetup(
          this.intentToken.client_secret, {
            payment_method: {
              card: this.card,
              billing_details: {
                name: this.name
              }
            }
          }
      ).then(function (result) {
        if (result.error) {
          this.addPaymentStatus = 3;
          this.addPaymentStatusError = result.error.message;
        } else {
          this.savePaymentMethod(result.setupIntent.payment_method);
          this.addPaymentStatus = 2;
          this.card.clear();
          this.name = '';
        }
        this.loader = false;
      }.bind(this));
    },
    savePaymentMethod(method) {
      axios.post('/payment/method/store', {
        payment_method: method
      }).then(function () {
        this.loadPaymentMethods();
      }.bind(this));
    },
    loadPaymentMethods() {
      this.paymentMethodsLoadStatus = 1;

      axios.get('/payment/payment-methods')
          .then(function (response) {
            this.paymentMethods = response.data;
            this.paymentMethodsLoadStatus = 2;
            this.loader = false;
          }.bind(this));
    },
    removePaymentMethod(paymentID) {
      this.loader = true;
      axios.post('/payment/method/remove', {
        id: paymentID
      }).then(function (response) {
        this.loadPaymentMethods();
      }.bind(this));
    },
    getStripeAPIToken() {
      axios.get('/payment/get-stripe-api-token')
          .then((response) => {
            if (response.data.success) {
              this.stripeAPIToken = response.data.stripeAPIToken;
              this.intentToken = response.data.intentToken;
              this.includeStripe('js.stripe.com/v3/', function () {
                this.configureStripe();
              }.bind(this));
            }
          })
          .catch((error) => {
            this.error = true
            console.log(error);
          });
    },

    includeStripe(URL, callback) {
      let documentTag = document, tag = 'script',
          object = documentTag.createElement(tag),
          scriptTag = documentTag.getElementsByTagName(tag)[0];
      object.src = '//' + URL;
      if (callback) {
        object.addEventListener('load', function (e) {
          callback(null, e);
        }, false);
      }
      scriptTag.parentNode.insertBefore(object, scriptTag);
    },
    configureStripe() {
      this.stripe = Stripe(this.stripeAPIToken);
      this.elements = this.stripe.elements();
      this.card = this.elements.create('card');

      this.card.mount('#card-element');
    },
  }

}
</script>

<style scoped>

</style>
