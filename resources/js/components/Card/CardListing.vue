<template>
    <div class="pt-card">
        <div class="pt-card--inner">
            <div class="pt-card--preview">
                <div class="pt-card--preview-img">
                    <img v-bind:src="path + '/storage/' + nurse.entity.original_photo"
                         alt="no-photo"
                         @error="$event.target.src=path + '/images/no-photo.jpg'">
                </div>
                <div class="pt-card--preview-rate">
                    <rate :user="nurse"></rate>
                </div>
            </div>
            <div class="pt-card--info">
                <div class="pt-card--info-top">
                    <div class="pt-card--info-general">
                        <div class="pt-card--info-name">
                            {{ nurse.first_name }} <div>{{ nurse.last_name }}</div>.
                        </div>
                        <div class="pt-card--info-age">
                            {{ nurse.entity.age }} Jahre Alt
                        </div>
                        <div class="pt-card--info-price">
                            €{{ nurse.entity.price.hourly_payment }}/stunde
                        </div>
                    </div>
                    <div class="pt-card--info-list">
                        <div class="pt-card--info-list--item" v-for="n in 4">
                            <pt-icon type="pin"></pt-icon>
                            <div class="">
                                <div class="pt-card--info-list--item-title">
                                    Ort:
                                </div>
                                <div class="pt-card--info-list--item-text">
                                    12345 Berlin
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-card--info-bottom">
                    <div class="pt-card--info-descr">
                        <pt-icon type="quotes"></pt-icon>
                        <p class="">
<!--                            {{ nurse.entity.description }}-->
                            This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum ...
                        </p>
                    </div>
                    <a href="" class="pt-btn--primary pt-sm"
                       @click.prevent="showNurseProfile(nurse)">
                        kontakt
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Rate from '../../pages/components/Rate';

export default {
    name: "CardListing",
    components: {
        rate: Rate,
    },
    props: ['nurse'],
    data(){
        return {
            path: location.origin,
        }
    },
    methods: {
        showNurseProfile(nurse) {
            this.$router.push({path: `/nurse/${nurse.id}`})
        },
    }
}
</script>

<style scoped>

</style>
