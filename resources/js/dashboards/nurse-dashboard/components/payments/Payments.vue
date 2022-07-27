<template>
    <div>
        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('hourly_payment') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="price.hourly_payment"
                              icon="help"
                              min="1" step="1"
                              @change="checkChangesInPrices()"
                              @update:modelValue="newValue => price.hourly_payment = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('weekend_surcharge') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>
                        <v-select :options="['yes', 'no']"
                                  v-model="price.weekend_surcharge">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('weekend_surcharge_payment') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="price.weekend_surcharge_payment"
                              icon="help"
                              min="10" step="10"
                              @change="checkChangesInPrices()"
                              @update:modelValue="newValue => price.weekend_surcharge_payment = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('holiday_surcharge') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>
                        <v-select :options="['yes', 'no']"
                                  v-model="price.holiday_surcharge">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('holiday_surcharge_payment') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="price.holiday_surcharge_payment"
                              icon="help"
                              min="10" step="10"
                              @change="checkChangesInPrices()"
                              @update:modelValue="newValue => price.holiday_surcharge_payment = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('fare_surcharge') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <div class="pt-select">
                        <div class="pt-select--icon">
                            <pt-icon type="help"></pt-icon>
                        </div>
                        <v-select :options="['yes', 'no']"
                                  v-model="price.fare_surcharge">
                            <template #open-indicator>
                                <span class="pt-select--caret"></span>
                            </template>
                        </v-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-finder--form-block">
            <div class="pt-finder--form-label">
                <div class="pt-finder--form-label--number">2</div>
                {{ $t('fare_surcharge_payment') }}
            </div>
            <div class="pt-finder--form-block--inner">
                <div class="pt-finder--form-group">
                    <pt-input type="number" :modelValue="price.fare_surcharge_payment"
                              icon="help"
                              min="10" max="50" step="5"
                              @change="checkChangesInPrices()"
                              @update:modelValue="newValue => price.fare_surcharge_payment = newValue"
                    ></pt-input>
                </div>
            </div>
        </div>
    </div>

    <button class="pt-btn--primary pt-md pt-mt-15 pt-ml-a pt-mr-a" v-on:click="storePrices()">Store</button>

    <!--<select id="for_whom" class="form-select form-select-sm" v-model="clientSearchInfo.for_whom">-->
    <!--    <option value="to_me">to_me</option>-->
    <!--    <option value="for_a_relative">for_a_relative</option>-->
    <!--</select>-->

</template>

<script>
export default {
    name: "Payments",
    props: ['user', 'data'],
    data() {
        return  {
            authUser: false,
            price : {}
        }
    },
    mounted() {
        this.getNurse();
    },
    methods: {
        getNurse() {
            axios.get('/dashboard/nurse/' + this.user.id)
                .then((response) => {
                    if (response.data.success) {
                        this.authUser = response.data.user;
                        this.price = this.authUser.entity.price;
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        storePrices() {
            this.user.entity.price = this.price;
            axios.put('/dashboard/nurse-payments/' + this.user.entity.id, {'price' : this.user.entity.price})
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        checkChangesInPrices(){
            console.log('test')
            this.price.hourly_payment = Math.round(this.price.hourly_payment);
            this.price.weekend_surcharge_payment = Math.ceil(this.price.weekend_surcharge_payment / 10) * 10;
            this.price.holiday_surcharge_payment = Math.ceil(this.price.holiday_surcharge_payment / 10) * 10;
            this.price.fare_surcharge_payment = Math.ceil(this.price.fare_surcharge_payment / 5) * 5;

            if(this.price.hourly_payment < 15){
                this.price.hourly_payment = 15;
            }

            if(this.price.weekend_surcharge_payment < 10){
                this.price.weekend_surcharge_payment = 10;
            }

            if(this.price.holiday_surcharge_payment < 10){
                this.price.holiday_surcharge_payment = 10;
            }

            if(this.price.fare_surcharge_payment < 5){
                this.price.fare_surcharge_payment = 5;
            }

            if(this.price.fare_surcharge_payment > 50){
                this.price.fare_surcharge_payment = 50;
            }
        }

    }
}
</script>

<style lang="scss">

</style>
