import template from './template.html';
import './style.css';

export default {
    name: "Payments",
    template: template,
    props: ['user', 'data'],
    data() {
        return  {
            price : {}
        }
    },
    mounted() {
        this.price = this.user.entity.price;
    },
    methods: {
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
