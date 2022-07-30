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
                    <pt-rate></pt-rate>
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
                        <div class="pt-card--info-list--item">
                            <pt-icon type="globe"></pt-icon>
                            <div class="">
                                <div class="pt-card--info-list--item-title">
                                    Sprachen:
                                </div>
                                <div class="pt-card--info-list--item-text">
                                    <span v-for="(lang) in nurse.entity.languages">{{lang.lang}}</span>
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
export default {
    name: "CardListing",
    components: {

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
